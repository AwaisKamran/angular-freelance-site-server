<?php
    ini_set('max_execution_time', 300);
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/rating.php');
    error_reporting(0);	
    
    if(isset($_GET['userId']) && $_GET['orderId']){
        $sql = 'select id, orderId, ratingComments, rating, dateTime, userId, 
        (
            select username from user where id =
            (select orderCreatedBy from orders where id = rating.orderId)
        ) as userName 
        from rating where userId = '. $_GET['userId'] . '&&orderId='. $_GET['orderId'];
    }
    else if(isset($_GET['userId']) && !isset($_GET['orderId'])){
        $sql = 'select id, orderId, ratingComments, rating, dateTime, userId, 
        ( 
            select username from user where id =
            (select orderCreatedBy from orders where id = rating.orderId)
        ) as userName
        from rating where userId = '. $_GET['userId'];
    }
    $array_rating = array();

	if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rating = new Rating;
            $rating->id = $row['id'];
            $rating->orderId = $row['orderId'];
            $rating->ratingComments = $row['ratingComments'];
            $rating->rating = $row['rating'];
            $rating->dateTime = $row['dateTime'];
            $rating->userId = $row['userId'];
            $rating->userName = $row['userName'];
            array_push($array_rating, $rating);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_rating;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get Ratings: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>