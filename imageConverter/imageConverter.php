<?php
      class ImageConverter {
        private $imageFormat = [ 'gif', 'jpeg', 'jpg', 'png', 'webp' ];

        private $constImageFormat = [ IMAGETYPE_GIF => 'gif', IMAGETYPE_JPEG => 'jpeg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp' ];

        private function getExtension($path) {
            $pathInfo = pathinfo($path);
            return $pathInfo['extension'];
        }

        private function getRealExtension($path) {
            $extension = exif_imagetype($path);
            return $extension;
        }

        private function loadImage($from) {
            $extension = $this->getRealExtension($from);
            $format = $this->constImageFormat[$extension];
            switch ($format) {
                case 'gif': $image = imagecreatefromgif($from); break;
                case 'jpg':
                case 'jpeg': $image = imagecreatefromjpeg($from); break;
                case 'png': $image = imagecreatefrompng($from); break;
                case 'webp': $image = imagecreatefromwebp($from); break;
                default: $image = null;
            }
            return $image;
        }

        private function saveImage($to, $image) {
            $extension = $this->getExtension($to);

            switch ($extension) {
                case 'gif': $image = imagegif($image, $to, 100); break;
                case 'jpg':
                case 'jpeg': $image = imagejpeg($image, $to, 100); break;          
                case 'png': $image = imagepng($image, $to, 9); break;
                case 'webp': $image = imagewebp($image, $to, 100); break;
                default: $image = null;
            }

            return $image;
        }

        public function convert($from, $to) {
            $image = $this->loadImage($from);
            $this->saveImage($to, $image);
            unlink($from);
        }
    }

    function convert($from, $to) {
      $converter = new ImageConverter();
      $converter->convert($from, $to);
    }
?>