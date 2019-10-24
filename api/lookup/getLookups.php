<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/lookup.php');
    error_reporting(0);	
    
    $sql = 'select * from lookup';

    $array_lookup = array();

	if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $lookup = new Lookup;
            $lookup->id = $row['id'];
            $lookup->type = $row['type'];
		    $lookup->value = $row['value'];
            array_push($array_lookup, $lookup);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_lookup;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get Lookup: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>