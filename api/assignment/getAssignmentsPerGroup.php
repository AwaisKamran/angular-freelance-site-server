<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/assignmentStatusModel.php');
    error_reporting(0);

    $sql = "SELECT status, count(*) as count FROM assignment group by status";

    $result = mysqli_query($conn, $sql);
    $array_assignments = array();
    
    
	if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $assignment = new AssignmentStatus;
            $assignment->statusId = $row['status'];
            $assignment->count= $row['count'];
            array_push($array_assignments, $assignment);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_assignments;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get Assignment Listings: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>