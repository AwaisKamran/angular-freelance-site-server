<?php
    include('../../cors.php');
    include('../../model/error.php');
    include('../../model/success.php');

    $target_dir = "../../uploads/assignments";
    $target_file = $target_dir . '/assignment-'.$_GET['id'].'.txt';
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if($imageFileType === 'docx') {
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

        $success = new Success;
        $success->success = true;
        echo json_encode($success);
    }
    else{
        $error = new CustomError;
        $error->description = "Error: Bulk Assignment Uploading: Only .xlsx files allowed.";
        $error->success = false;
        echo json_encode($error);
    }
?>