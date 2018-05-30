<?php
	//test the user uri
	$test_uri = user::uri();
	echo $test_uri."<br>";
	//test the user url
	$test_url = user::url();
	echo $test_url."<br>";
	//test the user port
	$test_port = user::port();
	echo $test_port."<br>";
	//test the user agent
	$test_agent = user::agent();
	echo $test_agent."<br>";
?>
