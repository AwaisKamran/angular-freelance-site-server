<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);	
    
    $data = json_decode(file_get_contents("php://input"), true)['data'];
    $name = $data['name'];
    $description = $data['description'];
    $createdBy = $data['createdBy'];

    $sql = "INSERT INTO groups (name, description, createdBy) VALUES ('$name','$description', '$createdBy')";
    	
	if (mysqli_query($conn, $sql)) {
        $success = new Success;
        $success->success = true;
        $success->data = mysqli_insert_id($conn); 
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Add Level: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>