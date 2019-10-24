<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/groups.php');
    error_reporting(0);	
    
    $sql = 'select * from groups';

    $array_groups = array();

	if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $groups = new Groups;
            $groups->id = $row['id'];
            $groups->name = $row['name'];
            $groups->description = $row['description'];
            array_push($array_groups, $groups);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_groups;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get groups: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>