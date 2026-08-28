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
        $tempDir = (getenv('VERCEL') || !is_writable(APPPATH . 'cache')) ? sys_get_temp_dir() : (APPPATH . 'cache');
        $tempJpgPath = rtrim($tempDir, '/\\') . DIRECTORY_SEPARATOR . 'compressed-' . time() . '-' . uniqid() . '.jpg';
        
        // Compress and convert the uploaded temp file to JPEG if GD is available
        $compressed = FALSE;
        if (extension_loaded('gd')) {
            $compressed = $this->image_optimizer->compress_to_jpg($_FILES['image']['tmp_name'], $tempJpgPath, 75);
        }

        // Fallback to original file if compression failed or GD is not loaded
        $fileToUpload = $compressed ? $tempJpgPath : $_FILES['image']['tmp_name'];
        $uploadMime = $compressed ? 'image/jpeg' : $mime;
        $extension = $compressed ? 'jpg' : pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        if (empty($extension)) {
            $extension = ($mime === 'image/webp') ? 'webp' : (($mime === 'image/png') ? 'png' : 'jpg');
        }

        // Upload to a separate 'uploads/' directory in Supabase storage
        $fileName = 'uploads/article-' . time() . '-' . uniqid() . '.' . $extension;

        try {
            $publicUrl = $this->supabase_uploader->upload($fileToUpload, $fileName, $uploadMime);
            // Clean up compressed temp file if it was created
            if ($compressed) {
                @unlink($tempJpgPath);
            }
            echo json_encode(['success' => true, 'url' => $publicUrl]);
        } catch (Exception $e) {
            if ($compressed) {
                @unlink($tempJpgPath);
            }
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
