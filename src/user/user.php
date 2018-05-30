<?php

  /*
  |--------------------------------------------------------------------------
  | user::fetch data from user
  |--------------------------------------------------------------------------
  |
  | This class supports:
  | - uri
  | - url
  | - ip
  | - port
  | - agent
  | - post
  | - get
  | - file
  | - dir
  |
  |
  */

namespace angel;

class user
{
    public static function uri()
    {
        return ltrim(rtrim(explode('?', $_SERVER['REQUEST_URI'])[0], '/'), '/');
    }

    public static function port()
    {
        return $_SERVER['REMOTE_PORT'];
    }

    public static function ip()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    public static function agent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    public static function post($input)
    {
        //if(isset($_POST['fromPerson'])
        if (is::ary($input)) {
            return ary::map($input, function ($key, $value) {
                return $_POST[$value];
            });
        } else {
            if ($input=='all') {
                return $_POST;
            } elseif (isset($_POST[$input])) {
                return $_POST[$input];
            } else {
                return false;
            }
        }
    }

    public static function file($input)
    {
        return $input=='all' ? $_FILES : $_FILES[$input];
    }

    public static function get($input)
    {
        if (isset(explode('?', $_SERVER['REQUEST_URI'])[1])) {
            $out = false;
            foreach (explode('&', explode('?', $_SERVER['REQUEST_URI'])[1]) as $value) {
                $value = explode('=', $value);
                $out[$value[0]] = $value[1];
            }
            if (is::ary($input)) {
                return ary::map($input, function ($key, $value) {
                    return $out[$value];
                });
            } else {
                if ($out) {
                    if ($input!='all' && isset($out[$input])) {
                        return $out[$input];
                    } elseif ($input==='all') {
                        return $out;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    public static function url()
    {
        return (isset($_SERVER['HTTPS'])?'https':'http').'://'.$_SERVER['HTTP_HOST'];
    }

    public static function dir($back=0)
    {
        $out = str_replace('\vendor\angel-project\core\src\user', '', str_replace('/vendor/angel-project/core/src/user', '', __dir__));
        if ($back<0) {
            if (is::in('/', $out)) {
                $array = str::split('/', $out);
                $out = '';
                foreach ($array as $key=>$value) {
                    if (($key-1)<(ary::size($array)+$back) and $value!='') {
                        $out .= '/'.$value;
                    }
                }
            } else {
                $array = str::split('\\', $out);
                $out = '';
                foreach ($array as $key=>$value) {
                    if (($key-1)<(ary::size($array)+$back) and $value!='') {
                        $out .= '\\'.$value;
                    }
                }
            }
        }
        return $out;
    }
}
