<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/user.php');
    error_reporting(0);

    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data['email'];
    $password = $data['password'];

    $sql = "select * from user where email='$email' && password='$password' and active=1";
    $result = mysqli_query($conn, $sql);
    $user = new User;
	if (mysqli_num_rows($result) > 0) {       
        while ($row = mysqli_fetch_assoc($result)) {
            $user->id = $row['id'];
            $user->name = $row['name'];
            $user->email = $row['email'];
            $user->password = $row['password'];
            $user->country = $row['country'];
            $user->active = $row['active'];
            $user->type = $row['type'];
            $user->level = $row['level'];
            $user->limitOfReservation = $row['limitOfReservation'];
        }

        $success = new Success;
        $success->success = true;
        $success->data = $user;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Modify User Limit Of Reservation: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>