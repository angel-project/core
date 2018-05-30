<?php

  /*
  |--------------------------------------------------------------------------
  | file::operation of files
  |--------------------------------------------------------------------------
  |
  | store a file:
  |
  | file::upload($_FILES['name'],$name);
  |
  | return: null
  |
  |--------------------------------------------------------------------------
  |
  | read a file:
  |
  | file::read($local_path);
  |
  | return: str
  |
  |--------------------------------------------------------------------------
  |
  | write a file:
  |
  | file::write([
  |   $path   =>  $value,
  |   $path_2 =>  $value_2
  | ]);
  |
  | return: null
  |
  |--------------------------------------------------------------------------
  |
  | force download a file:
  |
  | file::download($local_path,$name,$download_rate);
  | //third parameter is optional
  | //$download_rate is in kb/s
  |
  | return: null
  |
  |--------------------------------------------------------------------------
  |
  | delete a file:
  |
  | file::delete($path);
  |
  | return: null
  |
  |--------------------------------------------------------------------------
  |
  | zip files:
  |
  | file::zip($local_path,[
  |   $path_of_file_1,
  |   $path_of_file_2,
  |   $path_of_file_3
  | ]);
  |
  | return: null
  |
  |--------------------------------------------------------------------------
  |
  | unzip a zip file:
  |
  | file::unzip($zip_path,$extract_to_path);
  |
  | return: null
  |
  |
  |
  */

namespace angel;

class file
{
    public static function upload($file, $name)
    {
        if (!is::dir()) {
            $end = str::lower(ary::last(str::split(".", $file['name'])));
            if (is::in($end, ['json','txt','zip'])) {
                $to = $end;
            } else {
                $to = 'other';
            }
            $to = user::dir().'/file/'.$to;
        } else {
            $to = $name;
        }
        if (\move_uploaded_file($file['tmp_name'], $to.'/'.$name.'.'.$end)) {
            return true;
        } else {
            system::add_error('file::upload()', 'fail_upload', 'fail to upload file');
            return false;
        }
    }

    public static function read($path)
    {
        if (is::ary($path)) {
            return ary::map($path, function ($key, $value) {
                return file_get_contents($value);
            });
        } else {
            return file_get_contents($path);
        }
    }

    public static function write($path)
    {
        foreach ($path as $key=>$value) {
            $fp = fopen($key, 'w');
            fwrite($fp, $value);
            fclose($fp);
        }
    }

    public static function download($path, $name, $download_rate=20)
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.$name);
        header('Content-Transfer-Encoding: binary');
        header('Connection: Keep-Alive');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: '.filesize($path));
        flush();
        $file = fopen($path, "r");
        while (!feof($file)) {
            // send the current file part to the browser
            print fread($file, round($download_rate*1024));
            // flush the content to the browser
            flush();
            // sleep one second
            sleep(1);
        }
        fclose($file);
    }

    public static function delete($path)
    {
        if (is::ary($path)) {
            ary::map($path, function ($key, $value) {
                unlink($value);
                return 0;
            });
        } else {
            unlink($path);
        }
    }

    public static function zip($path, $addfile)
    {
        $fp = fopen($path, 'wb');
        fclose($fp);
        $zip = new \ZipArchive;
        $zip->open($path);
        foreach ($addfile as $key=>$value) {
            $zip->addFile($key, $value);
        }
        $zip->close();
    }

    public static function unzip($file, $path)
    {
        $zip = new \ZipArchive;
        $zip->open($file);
        $zip->extractTo($path);
        $zip->close();
    }

    public static function create($name)
    {
        if (is::ary($name)) {
            foreach ($name as $value) {
                $fp = fopen($value, 'w');
                fwrite($fp, "");
                fclose($fp);
            }
        } else {
            $fp = fopen($name, 'w');
            fwrite($fp, "");
            fclose($fp);
        }
    }
}
