<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image_optimizer {

    /**
     * Compress and convert any image format (PNG, JPEG, WebP) to JPEG format.
     * PNG transparency will be filled with a solid white background.
     *
     * @param string $sourcePath Local temporary file path
     * @param string $targetPath Destination local temporary file path (.jpg)
     * @param int $quality JPEG compression quality (0-100)
     * @return bool True on success, False on failure
     */
    public function compress_to_jpg($sourcePath, $targetPath, $quality = 75)
    {
        $info = @getimagesize($sourcePath);
        if (!$info) {
            return false;
        }

        $mime = $info['mime'];
        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = @imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $image = @imagecreatefrompng($sourcePath);
                if ($image) {
                    // Create a truecolor canvas with white background
                    $width = imagesx($image);
                    $height = imagesy($image);
                    $bg = imagecreatetruecolor($width, $height);
                    $white = imagecolorallocate($bg, 255, 255, 255);
                    imagefill($bg, 0, 0, $white);
                    
                    // Copy transparent PNG over the white canvas
                    imagecopy($bg, $image, 0, 0, 0, 0, $width, $height);
                    imagedestroy($image);
                    $image = $bg;
                }
                break;
            case 'image/webp':
                $image = @imagecreatefromwebp($sourcePath);
                break;
            case 'image/gif':
                $image = @imagecreatefromgif($sourcePath);
                break;
            default:
                return false;
        }

        if (!$image) {
            return false;
        }

        // Save image as JPEG with the specified quality
        $result = imagejpeg($image, $targetPath, $quality);
        imagedestroy($image);

        return $result;
    }
}
