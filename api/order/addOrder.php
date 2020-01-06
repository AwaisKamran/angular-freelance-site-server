<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);	
    
    $data = json_decode(file_get_contents("php://input"), true)['data'];
    $serviceId = $data['serviceId'];
    $hourRequired = $data['hoursRequired'];
    $budget = $data['budget'];
    $categoryId = $data['categoryId'];
    $subCategoryId = $data['subCategoryId'];
    $orderInstructions = $data['orderInstructions'];
    $status = $data['status'];
    $orderCreatedBy = $data['orderCreatedBy'];


    if($serviceId) $sql = "INSERT INTO orders (serviceId, hoursRequired, budget, orderInstructions, orderCreatedBy, status, categoryId, subCategoryId) VALUES ('$serviceId', '$hourRequired', '$budget', '$orderInstructions', '$orderCreatedBy' ,'$status', '$categoryId', '$subCategoryId'); ";
    else $sql = "INSERT INTO orders (hoursRequired, budget, orderInstructions, orderCreatedBy, status, categoryId, subCategoryId) VALUES ('$hourRequired', '$budget', '$orderInstructions', '$orderCreatedBy' ,'$status', '$categoryId', '$subCategoryId'); ";

	if (mysqli_query($conn, $sql)) {
        $success = new Success;
        $success->success = true;
        $success->data = mysqli_insert_id($conn); 
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Add Order: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }
    mysqli_close($conn);
?>