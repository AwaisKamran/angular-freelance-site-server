<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);	

    $sql = "select AVG(rating) as userRating from rating where userId=".$_GET['userId'];
	if ($result = mysqli_query($conn, $sql)) {
        $row = mysqli_fetch_assoc($result);
        $success = new Success;
        $success->success = true;
        $success->data = $row['userRating']; 
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get Average Rating: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }
    mysqli_close($conn);
?>