<?php
    include('../../cors.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);	

    $files = glob("../../uploads/order/order-". $_GET['orderId'].".*"); 
    if (count($files) > 0){
        $success = new Success;
        $success->success = true;
        $success->data = basename($files[0]);
        echo json_encode($success);
    }
    else{
        $error = new CustomError;
        $error->description = "Get File Name: Internal Server Error.";
        $error->success = false;
        echo json_encode($error);
    }
?>