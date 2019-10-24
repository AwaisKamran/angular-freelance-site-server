<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);	
    
    $data = json_decode(file_get_contents("php://input"), true)['data'];
    $name = $data['name'];
    $email = $data['email'];
    $password = $data['password'];
    $country = $data['country'];

    $sql = "INSERT INTO user (name, email, password, country, type, level) VALUES ('$name', '$email', '$password', '$country', (select id from lookup where value='freelancer'), (select id from level where name='Level 1' && type=(select id from lookup where value='user')))";
    	
	if (mysqli_query($conn, $sql)) {
        $success = new Success;
        $success->success = true;
        $success->data = mysqli_insert_id($conn); 
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Add Register User: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>