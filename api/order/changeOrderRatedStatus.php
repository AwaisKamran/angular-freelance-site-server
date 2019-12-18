<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);	
    
    $data = json_decode(file_get_contents("php://input"), true)['data'];
    $orderId = $data['orderId'];
    $newValue = $data['newValue'];
    $isAdmin = $data['isAdmin'];

    if($isAdmin)
        $sql = "Update orders set adminRated=1 where id='$orderId'";
    else
        $sql = "Update orders set freelancerRated=1 where id='$orderId'";

	if (mysqli_query($conn, $sql)) {
        $success = new Success;
        $success->success = true;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Modify Order Rated Flag: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>