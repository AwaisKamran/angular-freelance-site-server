<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);	
    
    $data = json_decode(file_get_contents("php://input"), true)['data'];
    $orderId = $data['orderId'];
    $userId = $data['userId'];
    $ratingComments = $data['ratingComments'];
    $rating = $data['rating'];

    $sql = "INSERT INTO rating (orderId, ratingComments, rating, userId) VALUES ('$orderId', '$ratingComments', '$rating', '$userId');";
	if (mysqli_query($conn, $sql)) {
        $success = new Success;
        $success->success = true;
        $success->data = mysqli_insert_id($conn); 
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Add Rating: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }
    mysqli_close($conn);
?>