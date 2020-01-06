<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/qualification.php');
    error_reporting(0);	
    
    $sql = 'select * from qualification where userId='. $_GET['userId'];

    $array_qualifications = array();

	if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $qualification = new Qualification;
            $qualification->id = $row['id'];
            $qualification->title = $row['title'];
            $qualification->institute = $row['institute'];
            $qualification->score = $row['score'];
            array_push($array_qualifications, $qualification);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_qualifications;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get Qualifications: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>