<?php
	$test_get = curl::get('https://www.google.com');
	assert(is::str($test_get));

	$test_post = curl::post('https://www.google.com', []);
	assert(is::str($test_post));

	echo "Curl test finished!"."<br>";
?>
