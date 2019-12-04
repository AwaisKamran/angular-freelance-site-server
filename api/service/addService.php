<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);	
    
    $data = json_decode(file_get_contents("php://input"), true)['data'];
    $title = $data['title'];
    $description = $data['description'];
    $hourlyCost = $data['hourlyCost'];
    $minimumHours = $data['minimumHours'];
    $userId = $data['userId'];
    $categoryId = $data['categoryId'];
    $subCategoryId = $data['subCategoryId'];
        
    $sql = "INSERT INTO service (title, description, hourlyCost, minimumHours, userId, categoryId, subCategoryId) VALUES ('$title', '$description', '$hourlyCost', '$minimumHours', ' $userId', '$categoryId', '$subCategoryId'); ";

	if (mysqli_query($conn, $sql)) {
        $success = new Success;
        $success->success = true;
        $success->data = mysqli_insert_id($conn); 
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Add Service: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>