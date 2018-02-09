<?php

  /*
  |--------------------------------------------------------------------------
  | ary::array operations
  |--------------------------------------------------------------------------
  |
  | map an array:
  |
  | ary::map($array, function($key,$value){
  |   //your code here
  |   return $str;
  | });
  |
  | returns: array
  |
  |--------------------------------------------------------------------------
  |
  | filter an array:
  |
  | ary::filter($array, function($key,$value){
  |   //your code here
  |   return true/false;
  | });
  |
  | returns: array
  |
  |--------------------------------------------------------------------------
  |
  | merge arrays:
  |
  | ary::merge([
  |   $array_1,
  |   $array_2,
  |   $array_3
  | ]);
  |
  | returns: array
  |
  |--------------------------------------------------------------------------
  |
  | flatten an array:
  |
  | ary::flat($array);
  |
  | returns: array
  |
  |--------------------------------------------------------------------------
  |
  | get array size:
  |
  | ary::size($array);
  |
  | returns: int
  |
  |--------------------------------------------------------------------------
  |
  | get last element of an array:
  |
  | ary::last($array);
  |
  | returns: str/int
  |
  |
  |
  */
  namespace angel;
  class ary {

    public static function map(array $array, $method) {
      if(gettype($method)==='object'){
        foreach($array as $key=>$value) {
          $array[$key] = call_user_func_array($method,[$key,$value]);
        }
        return $array;
      }else{
        system::add_error('ary::map()','missing_function','second parameter must be a function object');
      }
    }

    public static function filter(array $array, $method) {
      if(gettype($method)==='object'){
        $out = [];
        foreach ($array as $key=>$value) {
          if(call_user_func_array($method,[$key,$value])){
            $out[$key] = $value;
          }
        }
        return $out;
      }else{
        system::add_error('ary::filter()','missing_function','second parameter must be a function object');
      }
    }

    public static function merge(array $array) {
      return call_user_func_array('array_merge',$array);
    }

    public static function flat(array $array) {
      $out = [];
      foreach($array as $key=>$value) {
        if(is_array($value)){
          $out = array_merge($out,self::flat($value));
        }else{
          $out[] = $value;
        }
      }
      return $out;
    }

    public static function size(array $array) {
      return sizeof($array);
    }

    public static function last(array $array) {
        return array_values(array_slice($array, -1))[0];
    }

  }
