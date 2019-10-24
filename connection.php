<?php
	
	$servername = "localhost";
	$username = "root";
	$password = "";

	/*$servername = "localhost";
	$username = "lriwpilc_awais";
	$password = "destiny88Techlogix#";*/

	// Create connection
	$conn = mysqli_connect($servername, $username, $password);
	if (!$conn) {
		die('Could not connect: ' . mysqli_error($conn));
	}
	mysqli_select_db($conn, 'content');
	//mysqli_select_db($conn, 'lriwpilc_content');
?>