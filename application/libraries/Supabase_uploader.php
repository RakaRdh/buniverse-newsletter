<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supabase_uploader {

    protected $baseUrl;
    protected $serviceKey;
    protected $bucket;

    public function __construct()
    {
        $CI =& get_instance();
        $CI->config->load('supabase');

        $this->baseUrl    = $CI->config->item('supabase_url');
        $this->serviceKey = $CI->config->item('supabase_service_key');
        $this->bucket     = $CI->config->item('supabase_bucket');
    }

    /**
     * Upload file ke Supabase Storage, return public URL
     *
     * @param string $localFilePath  path file sementara ($_FILES['tmp_name'])
     * @param string $fileName       nama file tujuan, misal 'beritasatu/hero-1234.jpg'
     * @param string $mimeType       mime type file (image/jpeg, image/png, dst)
     * @return string public URL
     * @throws Exception kalau upload gagal
     */
    public function upload($localFilePath, $fileName, $mimeType)
    {
        $uploadUrl = sprintf(
            '%s/storage/v1/object/%s/%s',
            $this->baseUrl,
            $this->bucket,
            $fileName
        );

        $fileContent = file_get_contents($localFilePath);

        $ch = curl_init($uploadUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $fileContent,
            CURLOPT_SSL_VERIFYPEER => false, // Bypass SSL validation on local Windows machine
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $this->serviceKey,
                'apikey: ' . $this->serviceKey,
                'Content-Type: ' . $mimeType,
                'x-upsert: true', // overwrite kalau nama file sama
            ],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode < 200 || $httpCode >= 300) {
            throw new Exception('Upload ke Supabase gagal (HTTP ' . $httpCode . '): ' . $response);
        }

        // Format public URL Supabase Storage
        return sprintf(
            '%s/storage/v1/object/public/%s/%s',
            $this->baseUrl,
            $this->bucket,
            $fileName
        );
    }
}
