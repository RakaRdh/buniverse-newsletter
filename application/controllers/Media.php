<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('supabase_uploader');
        $this->load->library('image_optimizer');
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

        // Target temp file path for compressed JPEG
        $tempJpgPath = APPPATH . 'cache/compressed-' . time() . '-' . uniqid() . '.jpg';
        
        // Compress and convert the uploaded temp file to JPEG
        $compressed = $this->image_optimizer->compress_to_jpg($_FILES['image']['tmp_name'], $tempJpgPath, 75);
        if (!$compressed) {
            echo json_encode(['success' => false, 'message' => 'Gagal mengompresi gambar']);
            return;
        }

        // Upload to a separate 'uploads/' directory in Supabase storage
        $fileName = 'uploads/article-' . time() . '-' . uniqid() . '.jpg';

        try {
            $publicUrl = $this->supabase_uploader->upload($tempJpgPath, $fileName, 'image/jpeg');
            // Clean up compressed temp file
            @unlink($tempJpgPath);
            echo json_encode(['success' => true, 'url' => $publicUrl]);
        } catch (Exception $e) {
            @unlink($tempJpgPath);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
