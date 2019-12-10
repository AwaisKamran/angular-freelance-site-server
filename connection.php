<?php
	
	$servername = "localhost";
	$username = "root";
	$password = "";

	// $servername = "localhost";
	// $username = "awais";
	// $password = "destiny88";

	// Create connection
	$conn = mysqli_connect($servername, $username, $password);
	if (!$conn) {
		die('Could not connect: ' . mysqli_error($conn));
	}
	mysqli_select_db($conn, 'freelance');
	//mysqli_select_db($conn, 'freelance_service');
?>