<?php

  /*
  |--------------------------------------------------------------------------
  | jump::redirect
  |--------------------------------------------------------------------------
  |
  | redirect to history visits (input data saved):
  |
  | jump::back(-3); //default input -1
  |
  | redirected to history -3
  |
  |--------------------------------------------------------------------------
  |
  | redirect to an url:
  |
  | jump::to('https://www.zuggr.com/angel');
  |
  | redirected to https://www.zuggr.com/angel
  |
  |--------------------------------------------------------------------------
  |
  | refresh current page:
  |
  | jump::refresh();
  |
  |
  |
  */

namespace angel;

class jump
{
    public static function back($back=-1)
    {
        if ($back<0) {
            echo "<script>history.go(".$back.");</script>";
        } else {
            system::add_error('jump::back()', 'not_negative', 'only accepts negative input');
        }
    }

    public static function to($url)
    {
        echo "<script>parent.location.href='".$url."'; </script>";
    }

    public static function refresh()
    {
        header("Refresh:0");
    }
}
