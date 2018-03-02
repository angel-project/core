<?php

   assert(is::empty([]));
   assert(is::ary([1,2,3])&&(!is::ary(1)));
   assert(is::str("Hello World")&&!is::str([1]));
   assert(is::int(1)&&!is::int("111"));
   assert(is::float(0.1)&&!is::float(1));
   assert(!is::regex("+"));
   assert(!is::in("HELLO","hello world")&&is::in("hello","hello world"));
   assert(is::url("http://www.google.com")=="http://www.google.com"
        &&!is::url("google"));
   assert(is::dir("D:/")&&!is::dir("/D"));
   assert(is::email("user@email.com")=="user@email.com");

   echo 'Is Test Finished!'."<br>";
 ?>
