<?php

  /*
  |--------------------------------------------------------------------------
  | view::HTML interface builder
  |--------------------------------------------------------------------------
  |
  | Render a view:
  |
  | view::render('your_view.html',[
  |   'a_argument' => 'value_1',
  |   'b_argument' => 'value_2'
  | ]);
  |
  | echo: view
  |
  */

namespace angel;

class view
{
    public static $global_array = [];

    public static function global(array $input)
    {
        self::$global_array = ary::merge(self::$global_array, $input);
    }

    public static function render(string $file, array $input = [])
    {
        if (is::empty($input)) {
            $input = self::$global_array;
        } else {
            $input = ary::merge(self::$global_array, $input);
        }
        ob_start();
        require user::dir().'/view/'.$file;
        $out = ob_get_contents();
        ob_end_clean();
        $out = self::mobile($out);
        $out = self::mustache($out, $input);
        $out = self::angel_if($out);
        return $out;
    }

    public static function style(array $input)
    {
        $out = '';
        foreach ($input as $value) {
            if (is::url($value) or is::dir($value)) {
                $out .= '<link rel="stylesheet" href="'.$value.'" />';
            }
        }
        return $out;
    }

    public static function script(array $input)
    {
        $out = '';
        foreach ($input as $value) {
            if (is::url($value) or is::dir($value)) {
                $out .= '<script src="'.$value.'" type="text/javascript"></script>';
            }
        }
        return $out;
    }

    private static function mobile(string $out)
    {
        if (is::mobile()) {
            $out = str_replace(['<mobile>','</mobile>'], '', preg_replace('/(<desktop>)[\s\S]*(<\/desktop>)/u', '', $out));
        } else {
            $out = str_replace(['<desktop>','</desktop>'], '', preg_replace('/(<mobile>)[\s\S]*(<\/mobile>)/u', '', $out));
        }
        return $out;
    } //<mobile> & <desktop> special tag support

    private static function mustache(string $out, array $input)
    {
        foreach ($input as $key=>$value) {
            $out = str::replace(sprintf('{{{'.$key.'}}}'), $value, $out);
        }
        return $out;
    } //mustache support

    private static function angel_if(string $out)
    {
        $out = preg_replace('/(<angel if="no_if">)[\s\S]*?(<\/angel>)/is', '', (string)$out);
        $out = preg_replace('/(<angel if=\'no_if\'>)[\s\S]*?(<\/angel>)/is', '', (string)$out);
        return str_replace(['<angel if="yes_if">','<angel if=\'yes_if\'>','</angel>'], '', $out);
    }

    public static function if($in)
    {
        if ($in) {
            return 'yes_if';
        } else {
            return 'no_if';
        }
    }
}
