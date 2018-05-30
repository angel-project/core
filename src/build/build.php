<?php

  /*
  |--------------------------------------------------------------------------
  | build::bind routing pattern & method in array
  |--------------------------------------------------------------------------
  |
  | Define a get rule:
  |
  | build::get('pattern/[a]/[b]',function($a,$b){
  |   //your code here
  | });
  |
  | returns: null
  |
  |--------------------------------------------------------------------------
  |
  | Define a post rule:
  |
  | build::post('pattern/[a]/[b]',function($a,$b){
  |   //your code here
  | });
  |
  | returns: null
  |
  |
  |
  */

namespace angel;

class build
{
    public static $post_methods = [];

    public static $get_methods = [];

    public static function post($pattern, $method)
    {
        $list =& self::$post_methods;
        if (!array_key_exists($pattern, $list)) {
            $list[$pattern] = $method;
        } else {
            system::add_error('build::post()', 'conflict', 'method name '.$pattern.' in conflict');
        }
    }

    public static function get($pattern, $method)
    {
        $list =& self::$get_methods;
        if (!array_key_exists($pattern, $list)) {
            $list[$pattern] = $method;
        } else {
            system::add_error('build::get()', 'conflict', 'method name '.$pattern.' in conflict');
        }
    }
}
