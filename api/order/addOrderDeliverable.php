<?php
    include('../../cors.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);	

    $path_parts = pathinfo($_FILES["fileToUpload"]["name"]);
    $extension = $path_parts['extension'];

    $target_dir = "../../uploads/order";
    $target_file = $target_dir . '/order-'.$_GET['orderId']. '.' .$extension;
    
    if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)){
        $success = new Success;
        $success->success = true;
        echo json_encode($success);
    }
    else{
        $error = new CustomError;
        $error->description = "Error: Add Order Deliverable: file format not supported.";
        $error->success = false;
        echo json_encode($error);
    }
?>