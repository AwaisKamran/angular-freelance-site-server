<?php 
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/assignment.php');
    include('../../model/level.php');
    include('../../model/language.php');
    include('../../model/user.php');
    error_reporting(0);

    $file_pointer = '../../uploads/assignments/assignment-'.$_GET['id'].'.docx'; 

    if (file_exists($file_pointer))  
    { 
        $success = new Success;
        $success->success = true;
        $success->data = null;
        echo json_encode($success);
    } 
    else 
    { 
        $error = new CustomError;
        $error->description = "File Does not exist: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }
?> 