<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/user.php');
    include('../../model/level.php');
    error_reporting(0);	
    

    $sql = 'select 
    user.id,
    user.name,
    user.email,
    user.password,
    user.country,
    user.active,
    user.type,
    user.limitOfReservation,

    level.id as levelId,
    level.name as levelName,
    level.payrate as payrate

    from user left outer join level 
    on user.level = level.id';

    $array_users = array();

	if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $user = new User;
            $user->id = $row['id'];
            $user->name = $row['name'];
		    $user->email = $row['email'];
		    $user->password = $row['password'];
		    $user->country = $row['country'];
		    $user->active = ($row['active'] === '1'? true: false);
		    $user->type = $row['type'];
            $user->limitOfReservation = $row['limitOfReservation'];

            $level = new Level;
            $level->id = $row['levelId'];
            $level->name = $row['levelName'];
            $level->payrate = $row['payrate'];

            $user->level = $level;
            array_push($array_users, $user);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_users;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get User Listings: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>