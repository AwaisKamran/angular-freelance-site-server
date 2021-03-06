<?php
    include('../../cors.php');    
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);	
    
    $data = json_decode(file_get_contents("php://input"), true)['data'];
    $orderId = $data['orderId'];
    $serviceId = $data['serviceId'];
    $timeRequired = $data['timeRequired'];
    $bidDescription = $data['bidDescription'];
    $proposedBudget = $data['proposedBudget'];
    $proposedBy = $data['proposedBy'];

    $sql = "INSERT INTO bids (orderId, serviceId, timeRequired, proposedBudget, proposedBy, bidDescription) VALUES ('$orderId', '$serviceId', '$timeRequired', '$proposedBudget', '$proposedBy', '$bidDescription')";
    	
	if (mysqli_query($conn, $sql)) {
        $success = new Success;
        $success->success = true;
        $success->data = mysqli_insert_id($conn); 
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Add Bid: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>