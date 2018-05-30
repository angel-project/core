<?php

  /*
  |--------------------------------------------------------------------------
  | curl::request outside resource
  |--------------------------------------------------------------------------
  |
  | GET method request:
  |
  | curl::get('http://www.zuggr.com/angel');
  |
  | returns: string
  |
  |--------------------------------------------------------------------------
  |
  | POST method request:
  |
  | curl::post('http://www.zuggr.com/angel',[
  |   'post_data_a' => 'foo',
  |   'post_data_b' => 'bar',
  |   'post_file' => 'file@your_file_location'
  | ]);
  |
  | returns: string
  |
  |
  |
  */

namespace angel;

class curl
{
    public static function get($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        if (curl_errno($ch)) {
            system::add_error('curl::get()', curl_error($ch), 'cURL get error: '.curl_error($ch));
        }
        curl_close($ch);
        return $output;
    }

    public static function post($url, $data)
    {
        if (is_array($data)) {
            foreach ($data as $key=>$in) {
                if (strpos($in, 'file@')) {
                    $data[$key]=curl_file_create(str_replace('file@', '', $in));
                }
            } //file str to obj
            $data = http_build_query($data);
        } //array to post str
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        if (curl_errno($ch)) {
            system::add_error('curl::post()', curl_error($ch), 'cURL post error: '.curl_error($ch));
        }
        curl_close($ch);
        return $output;
    }
}
