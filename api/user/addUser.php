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
    $telephone = $data['telephone'];
    $telephone = $data['country'];
    $telephone = $data['city'];
    $travelRadius = $data['travelRadius'];
    $active = $data['active'];
    $type = $data['type'];

    $sql = "INSERT INTO user (username, email, password, telephone, travelRadius, active, type) VALUES ('$name', '$email', '$password', '$telephone', '$travelRadius', '$active', '$type')";
    	
	if (mysqli_query($conn, $sql)) {
        $success = new Success;
        $success->success = true;
        $success->data = mysqli_insert_id($conn); 
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Add User: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>