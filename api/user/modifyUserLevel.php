<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);	
    
    $data = json_decode(file_get_contents("php://input"), true)['data'];
    $newValue = $data['value'];
    $id = $data['id'];

    $sql = "Update user set level='$newValue' where id='$id'";
    	
	if (mysqli_query($conn, $sql)) {
        $success = new Success;
        $success->success = true;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Modify User Level: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>