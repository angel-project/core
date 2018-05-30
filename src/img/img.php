<?php

  /*
  |--------------------------------------------------------------------------
  | img::operation for images
  |--------------------------------------------------------------------------
  |
  | Store an image:
  |
  | img::upload($_FILE['name'],'a_name',100);
  |
  | //upload to ./file/img
  | //third parameter is optional
  |
  |
  |
  */

  namespace angel;

class img
{
    public static function upload($file, $name, $quality=100)
    {
        if (!is::empty($file)) {
            if (strpos(strtolower($file['name']), 'png')) {
                $quality = round($quality*0.1);
                $quality = $quality<9?$quality:9;
                if (imagepng(imagecreatefrompng($file['tmp_name']), user::dir().'/file/img/'.$name.'.png', $quality)) {
                    return $name.'.png';
                } else {
                    system::add_error('img::upload()', 'store_png_fail', 'fail to store png file: '.$file['name'].', please check your file permission');
                    return false;
                }
            } elseif (strpos(strtolower($file['name']), 'gif')) {
                if (move_uploaded_file($file['tmp_name'], user::dir().'/file/img/'.$name.'.gif')) {
                    return $name.'.gif';
                } else {
                    system::add_error('img::upload()', 'store_gif_fail', 'fail to store gif file: '.$file['name'].', please check your file permission');
                    return false;
                }
            } elseif ((strpos(strtolower($file['name']), 'jpg') or strpos(strtolower($file['name']), 'jpeg'))) {
                if (imagejpeg(imagecreatefromjpeg($file['tmp_name']), user::dir().'/file/img/'.$name.'.jpeg', $quality)) {
                    return $name.'.jpeg';
                } else {
                    system::add_error('img::upload()', 'store_jpeg_fail', 'fail to store jpeg file: '.$file['name'].', please check your file permission');
                    return false;
                }
            } else {
                system::add_error('img::upload()', 'not_img', 'not an image file');
            }
        } else {
            system::add_error('img::upload()', 'empty', 'empty file');
        }
    }
}
