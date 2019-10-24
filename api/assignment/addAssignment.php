<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);	
    
    $data = json_decode(file_get_contents("php://input"), true)['data'];
    $title = $data['title'];
    $description = $data['description'];
    $words = $data['words'];
    $type = $data['type'];
    $language = $data['language'];
    $status = $data['status'];
    //$dueDate = $data['dueDate'];
    $createdBy = $data['createdBy'];
    $assignmentInternalComment = $data['assignmentInternalComment'];

    $sql = "INSERT INTO assignment (title, type, assignmentInternalComment, language, status, createdBy, description, words) VALUES ('$title', '$type', '$assignmentInternalComment', '$language', '$status', '$createdBy', '$description', '$words')";

	if (mysqli_query($conn, $sql)) {
        $success = new Success;
        $success->success = true;
        $success->data = mysqli_insert_id($conn); 
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Add Assignment: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>