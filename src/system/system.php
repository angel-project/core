<?php

  /*
  |--------------------------------------------------------------------------
  | system::debug methods
  |--------------------------------------------------------------------------
  |
  | For Angel developers:
  |
  | system::get_runtime('on');
  |
  | system::get_error('on');
  |
  | system::autoload($local_path); //autoload every PHP files under a path
  |
  |--------------------------------------------------------------------------
  |
  | For Angel builders:
  |
  | system::add_error($method_name,$error);
  |
  |
  |
  */

namespace angel;

class system
{
    public static $error = [];

    public static $debug = '';

    public static function add_error($method, $code, $error)
    {
        self::$debug = $method.':'.$code;
        $cry = '<strong>Angel crying:</strong> '.$method.', '.$error.'<br>';
        array_push(self::$error, $cry);
    }

    public static function get_error($switch)
    {
        if ($switch==='on') {
            foreach (self::$error as $cry) {
                echo $cry;
            }
        }
    }

    public static function get_runtime($switch)
    {
        if ($switch==='on') {
            echo '<br>Process Time: ',(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]),'s';
        }
    }

    public static function autoload($dir)
    {
        foreach (glob($dir.'/*') as $file) {
            if (!is::in('.', $file)) {
                self::autoload($file);
            } elseif (is::in('.php', $file)) {
                require_once $file;
            }
        }
    }

    public static function test($method="all")
    {
        $all_tests = ['ary','build','curl','is','js','jump','str','user'];
        if ($method=="all") {
            foreach ($all_tests as $key) {
                require_once realpath(dirname(__FILE__).'/../'.$key.'/test.php');
            }
        } else {
            require_once realpath(dirname(__FILE__).'/../'.$method.'/test.php');
        }
    }
}
