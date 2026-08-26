<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('supabase_uploader');
    }

    public function upload_image()
    {
        if (empty($_FILES['image']['tmp_name'])) {
            echo json_encode(['success' => false, 'message' => 'Tidak ada file diupload']);
            return;
        }

        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        $mime = mime_content_type($_FILES['image']['tmp_name']);
        if (!in_array($mime, $allowed)) {
            echo json_encode(['success' => false, 'message' => 'Format file tidak didukung']);
            return;
        }

        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName  = 'article-' . time() . '-' . uniqid() . '.' . $extension;

        try {
            $publicUrl = $this->supabase_uploader->upload($_FILES['image']['tmp_name'], $fileName, $mime);
            echo json_encode(['success' => true, 'url' => $publicUrl]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
