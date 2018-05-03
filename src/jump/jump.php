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
  class jump {
    //jump back to a history page
    public static function back($back=-1){
      if($back<0){
        echo "<script>history.go(".$back.");</script>";
      }else{
        system::add_error('jump::back()','not_negative','only accepts negative input');
      }
    }
    //change to some url
    public static function to($url){
      echo "<script>parent.location.href='".$url."'; </script>";
    }
    //refresh current page
    public static function refresh(){
      header("Refresh:0");
    }

  }
