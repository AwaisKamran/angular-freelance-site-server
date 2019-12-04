<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);

    $target_dir = "../../uploads/". $_POST['folder'];
    $target_file = $target_dir .'/'. $_POST['id'].'.jpg';

    if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
    {
        $success = new Success;
        $success->success = true;
        $success->data = null;
        echo json_encode($success);
    }
    else{
        $error = new CustomError;
        $error->description = "Image uploading failed.";
        $error->success = false;
        echo json_encode($error);
    }
?>