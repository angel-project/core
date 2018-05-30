<?php

  /*
  |--------------------------------------------------------------------------
  | run::match uri & run build:: accordingly
  |--------------------------------------------------------------------------
  |
  | This class is uesed by bootstrap.php only as a routing system method
  |
  |
  */

namespace angel;

class run
{
    public static function post($trigger)
    {
        $list =& build::$post_methods;
        self::compile($trigger, $list);
    }

    public static function get($trigger)
    {
        $list =& build::$get_methods;
        self::compile($trigger, $list);
    }

    private static function compile($trigger, $list)
    {
        if (array_key_exists($trigger, $list)) {
            call_user_func_array($list[$trigger], []);
        } else {
            $found = false;
            foreach ($list as $pattern=>$method) {
                if ($var = self::match(explode('/', $trigger), explode('/', $pattern))) {
                    $found = true;
                    call_user_func_array($list[$pattern], $var);
                    break;
                }
            }
            if (!$found) {
                call_user_func_array($list['404'], []);
            } //call 404 if routing pattern isn't found
        }
    }

    private static function match($trigger, $pattern)
    {
        $var = [];
        $count = 0;
        if (ary::size($trigger)===ary::size($pattern)?true:false) {
            foreach ($pattern as $i) {
                $format_p = $i[0]==='[' ? ['var', str_replace(['[',']'], '', $i)] : [$i, ''];
                if ($format_p[0]!='var' && $format_p[0]!=$trigger[$count]) {
                    $var = false;
                    break;
                } elseif ($format_p[0]==='var') {
                    $var[$format_p[1]] = $trigger[$count];
                }
                $count += 1;
            }
        } //uri and pattern must have same size
        return $var;
    }
}
