<?php

  /*
  |--------------------------------------------------------------------------
  | js::simple js builder
  |--------------------------------------------------------------------------
  |
  | build an alert:
  |
  | js::alert('your alert msg');
  |
  | echos js code
  |
  |
  |
  */

<<<<<<< HEAD
namespace angel;

class js
{
    public static function alert($content='')
    {
        echo "<script>alert('",$content,"')</script>";
=======
  namespace angel;
  class js {
    //a simple js alert function
    public static function alert($content=''){
      echo "<script>alert('",$content,"')</script>";
>>>>>>> cf1d9ed75853b8fd71d992d3eea3611b85e229c9
    }
}
