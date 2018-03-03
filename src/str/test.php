<?php

  assert(str::html('hello world')=='hello&nbsp;world');
  assert(str::utf8('hello&nbsp;world')=='hello world');
  assert(str::cut('hello world',7)=='hello w');
  assert(str::lower('HELLO WORLD')=='hello world');
  assert(str::upper('hello world')=='HELLO WORLD'&&str::upper(['h','com'])==['H','COM']);
  assert(strlen(str::random(8))==8);
  assert(str::unix_dir('D:\angel_home')=='D:/angel_home');
  echo 'String Test Finished!'."<br>";
 ?>
