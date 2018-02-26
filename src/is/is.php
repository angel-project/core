<?php

  /*
  |--------------------------------------------------------------------------
  | is::judger (returns: true/false)
  |--------------------------------------------------------------------------
  |
  | if user is using mobile device:
  |
  | if(is::mobile()){
  |   //your code here
  | }
  |
  |--------------------------------------------------------------------------
  |
  | if array, $_FILES or string is empty:
  |
  | if(is::empty($array_file_or_str)){
  |   //your code here
  | }
  |
  |--------------------------------------------------------------------------
  |
  | if input is array:
  |
  | if(is::ary($input)){
  |   //your code here
  | }
  |
  |--------------------------------------------------------------------------
  |
  | if input is str:
  |
  | if(is::str($input)){
  |   //your code here
  | }
  |
  |--------------------------------------------------------------------------
  |
  | if input is int:
  |
  | if(is::int($input)){
  |   //your code here
  | }
  |
  |--------------------------------------------------------------------------
  |
  | if input is float:
  |
  | if(is::float($input)){
  |   //your code here
  | }
  |
  |--------------------------------------------------------------------------
  |
  | if input is regex expression:
  |
  | if(is::regex($input)){
  |   //your code here
  | }
  |--------------------------------------------------------------------------
  |
  | if input is contains a string or a regex expression:
  |
  | if(is::in($regex_rule_or_str, $match_str)){
  |   //your code here
  | }
  |
  |
  |
  */

  namespace angel;
  class is {

    public static function mobile() {
      $agent = strtolower(user::agent());
      return strpos($agent, 'mobile') || strpos($agent, 'android') || strpos($agent, 'iphone');
    }

    public static function empty($in_p=null) {
      $flag = false;
      if(is::ary($in_p)){
        if(array_key_exists('error',$in_p)){
          if($in_p['error'] === UPLOAD_ERR_NO_FILE){
            $flag = true;
          } //if $_FILES is empty
        }elseif(empty($in_p)){
          $flag = true; //if array as whole is empty
        }
      }else{
        if(empty($in_p)){
          $flag = true;
        } //if str is empty
      }
      return $flag;
    }

    public static function ary($input) {
      return is_array($input);
    }

    public static function str($input) {
      return gettype($input)==='string'?true:false;
    }

    public static function int($input) {
      return gettype($input)==='integer'?true:false;
    }

    public static function float($input) {
      return is_float($input);
    }

    public static function error($method,$error) {
      return $method.':'.$error===system::$debug;
    }

    public static function regex($input) {
      return @preg_match($input,'')!==false?true:false;
    }

    public static function in($part,$full) {
      $flag = false;
      if(is::ary($full)){
        foreach ($full as $key=>$value) {
          if(is::regex($part)){
            if(preg_match($part,$value)){
              $flag = true;
            }
          }else{
            if(!(strstr($value,$part)===false) or $value==$part){
              $flag = true;
            }
          }
        }
      }else{
        if(is::regex($part)){
          if(preg_match($part,$full)){
            $flag = true;
          }
        }else{
          if(strstr($full,$part)!=false){
            $flag = true;
          }
        }
      }
      return $flag;
    }

    public static function url(string $url){
      return filter_var($url, FILTER_VALIDATE_URL);
    }


    public static function dir(string $dir){
      return file_exists($dir);
    }

    public static function email(string $email){
      return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function multi_layer($input){
      $rv = array_filter($input,'is_array');
      if(count($rv)>0){
        return true;
      }else{
        return false;
      }
    }

  }
