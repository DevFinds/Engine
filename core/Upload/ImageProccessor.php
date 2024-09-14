<?php

namespace Core\Upload;

class ImageProcessor
{
    public function resizeImage(string $filePath, int $width, int $height): bool
    {
        $info = getimagesize($filePath);
        $type = $info[2];

        if ($type == IMAGETYPE_JPEG) {
            $image = imagecreatefromjpeg($filePath);
        } elseif ($type == IMAGETYPE_PNG) {
            $image = imagecreatefrompng($filePath);
        } else {
            return false;
        }

        $newImage = imagescale($image, $width, $height);
        return $this->saveImage($newImage, $filePath, $type);
    }

    private function saveImage($image, string $filePath, int $type): bool
    {
        if ($type == IMAGETYPE_JPEG) {
            return imagejpeg($image, $filePath);
        } elseif ($type == IMAGETYPE_PNG) {
            return imagepng($image, $filePath);
        }

        return false;
    }
}
