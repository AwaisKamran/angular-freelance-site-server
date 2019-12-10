<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);	
    
    $data = json_decode(file_get_contents("php://input"), true)['data'];
    $serviceId = $data['serviceId'];
    $hourRequired = $data['hourRequired'];
    $budget = $data['budget'];
    $orderInstructions = $data['orderInstructions'];
    $status = $data['status'];

    $sql = "INSERT INTO orders (serviceId, hourRequired, budget, orderInstructions, status) VALUES ('$serviceId', '$hourRequired', '$budget', '$orderInstructions', '$status'); ";

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