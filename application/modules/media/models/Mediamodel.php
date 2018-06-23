<?php

class MediaModel extends CI_model {

    public function resize($filename, $width, $height) {
        $mediaLocation = $this->config->item('media_location');
        if(empty($mediaLocation)){
            die("Define the media location directory.");
        }
        $mediaStore = FCPATH.$mediaLocation.'/';
        if (!is_file($mediaStore . $filename)) {
            return;
        }
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $image_old = $filename;
        $image_new = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
        if (!is_file($mediaStore . $image_new) || (filectime($mediaStore . $image_old) > filectime($mediaStore . $image_new))) {
            list($width_orig, $height_orig, $image_type) = getimagesize($mediaStore . $image_old);

            if (!in_array($image_type, array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF))) {
                return $mediaStore . $image_old;
            }

            $path = '';

            $directories = explode('/', dirname($image_new));

            foreach ($directories as $directory) {
                $path = $path . '/' . $directory;

                if (!is_dir($mediaStore . $path)) {
                    @mkdir($mediaStore . $path, 0777);
                }
            }
            
            if ($width_orig != $width || $height_orig != $height) {
                $image = new Image($mediaStore . $image_old);
                $image->resize($width, $height);
                $image->save($mediaStore . $image_new);
            } else {
                copy($mediaStore . $image_old, $mediaStore . $image_new);
            }
        }


        return site_url() . $this->config->item('media_location').'/' . $image_new;
    }

}
