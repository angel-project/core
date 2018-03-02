<?php
  $test_get = build::get('', function(){});
  assert($test_get == null);

  $test_post = build::post('', function(){});
  assert($test_post == null);

  echo "Build Test Finished!"."<br>";
?>
