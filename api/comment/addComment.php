<?php
    include('../../cors.php');    
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);	
    
    $data = json_decode(file_get_contents("php://input"), true)['data'];
    $commentText = $data['commentText'];
    $userId = $data['userId'];
    $orderId = $data['orderId'];

    $sql = "INSERT INTO comments (userId, orderId, commentText) VALUES ('$userId', '$orderId', '$commentText')";
    	
	if (mysqli_query($conn, $sql)) {
        $success = new Success;
        $success->success = true;
        $success->data = mysqli_insert_id($conn); 
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Add Comment: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>