<?php

  /*
  |--------------------------------------------------------------------------
  | str::format strings
  |--------------------------------------------------------------------------
  |
  | format to HTML:
  |
  | str::html($str);
  |
  | returns: string
  |
  |--------------------------------------------------------------------------
  |
  | format to utf-8:
  |
  | str::utf8($str);
  |
  | returns: string
  |
  |--------------------------------------------------------------------------
  |
  | return part of a str with length of 10:
  |
  | str::cut($str);
  |
  | returns: string
  |
  |--------------------------------------------------------------------------
  |
  | return a random str:
  |
  | str::random(10);
  |
  | returns: string
  |
  |--------------------------------------------------------------------------
  |
  | split str to array:
  |
  | str::split(' ','hello world');
  |
  | returns: array = ['hello','world']
  |
  |--------------------------------------------------------------------------
  |
  | replace string according to a rule:
  |
  | str::replace(['hello','wrold'],'good','hello world');
  |
  | returns: str = 'good good'
  |
  |--------------------------------------------------------------------------
  |
  | upper and lower case a string:
  |
  | str::upper($str);/str::lower($str);
  |
  | returns: str
  |
  |
  */

namespace angel;

class str
{
    //transform the given string into html format
    //strings
    public static function html(string $in_p)
    {
        $pro=htmlspecialchars($in_p);
        $pro=preg_replace("/(\\r)+(\\n)+/", "<br>", $pro);
        $pro=preg_replace("/(<br>){2,}/", "<br><br>", $pro);
        $pro=str_replace(" ", "&nbsp;", $pro);
        return preg_replace("/(&nbsp;){2,}/", "&nbsp;&nbsp;", $pro);
    }
    //transform the given string into utf8 format strings
    public static function utf8(string $in_p)
    {
        $value = str_replace("<br>", "\n", $in_p);
        return str_replace("&nbsp;", " ", $value);
    }
    //cut the given string and return the new string containing $limit characters
    public static function cut(string $in_p, $limit)
    {
        //if the $limit does not start from the first letter
        if (is::ary($limit)) {
            return mb_substr($in_p, $limit[0], $limit[1], 'UTF-8');
        } else {
            return mb_substr($in_p, 0, $limit, 'UTF-8');
        }
    }
    //randomly create a string of length $limit
    public static function random($limit=10)
    {
        //select characters from the characters below
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYMZabcdefghijklmnopqrstuvwxyz';
        $string='';
        $max=strlen($characters)-1;
        for ($i=0;$i<$limit;$i++) {
            $string.=$characters[mt_rand(0, $max)];
        }
        return $string;
    }
    //split the string by delimiter $flag
    public static function split($flag, string $str)
    {
        return explode($flag, $str);
    }
    //find all $match in the $org string and replace
    //these strings by $replace
    public static function replace($match, $replace, $org)
    {
        //if $match satisfies regular expression
        if (is::regex($match)) {
            return preg_replace($match, $replace, $org);
        } else {
            return str_replace($match, $replace, $org);
        }
    }
    //change all the letters into lower letters
    //no matter if $input is strings or an array
    //of strings
    public static function lower($input)
    {
        if (is::ary($input)) {
            return ary::map($input, function ($key, $value) {
                return strtolower($value);
            });
        } else {
            return strtolower($input);
        }
    }
    //change all the letters into upper letters
    //no matter if $input is strings or an array
    //of strings
    public static function upper($input)
    {
        if (is::ary($input)) {
            return ary::map($input, function ($key, $value) {
                return strtoupper($value);
            });
        } else {
            return strtoupper($input);
        }
    }
    //change windows directory into unix directory
    public static function unix_dir(string $path)
    {
        $path = str_replace('\\', '/', $path);
        $path = preg_replace('|(?<=.)/+|', '/', $path);
        if (':' === substr($path, 1, 1)) {
            $path = ucfirst($path);
        }
        return $path;
    }
    //change unix directory into windows directory
    public static function windows_dir(string $path)
    {
        $path = str_replace('/', '\\', $path);
        $path = preg_replace('|(?<=.)/+|', '\\', $path);
        if (':' === substr($path, 1, 1)) {
            $path = ucfirst($path);
        }
        return $path;
    }
}
