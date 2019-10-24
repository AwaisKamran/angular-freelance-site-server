<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/level.php');
    error_reporting(0);	
    
    $sql = 'select * from level';

    $array_level = array();

	if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $level = new Level;
            $level->id = $row['id'];
            $level->name = $row['name'];
            $level->description = $row['description'];
            $level->payrate = $row['payrate'];
            $level->type = $row['type'];
            array_push($array_level, $level);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_level;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get level: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>