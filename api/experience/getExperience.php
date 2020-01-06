<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/experience.php');
    error_reporting(0);	
    
    $sql = 'select * from experience where userId='. $_GET['userId'];

    $array_experiences = array();

	if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $experience = new Experience;
            $experience->id = $row['id'];
            $experience->title = $row['title'];
            $experience->companyName = $row['companyName'];
            $experience->startYear = $row['startYear'];
            $experience->endYear = $row['endYear'];
            array_push($array_experiences, $experience);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_experiences;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get experiences: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>