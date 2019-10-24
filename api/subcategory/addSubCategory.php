<?php
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);	
    
    $data = json_decode(file_get_contents("php://input"), true)['data'];
    $name = $data['name'];
    $description = $data['description'];
    $categoryId = $data['categoryId'];
    $createdBy = $data['createdBy'];
    $createdDate = $data['createdDate'];

    $sql = "INSERT INTO subcategory (name, description, categoryId, createdBy, createdDate) VALUES ('$name', '$description', '$categoryId', '$createdBy', '$createdDate')";
    	
	if (mysqli_query($conn, $sql)) {
        $success = new Success;
        $success->success = true;
        $success->data = mysqli_insert_id($conn); 
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Add SubCategory: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>