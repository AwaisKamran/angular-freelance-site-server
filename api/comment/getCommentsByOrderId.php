<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/comment.php');
    error_reporting(0);	
    
    $sql = 'select * from comments where orderId='. $_GET['orderId'] .' order by dateTime desc';

    $array_comments = array();

	if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $comment = new Comment;
            $comment->id = $row['id'];
            $comment->userId = $row['userId'];
            $comment->orderId = $row['orderId'];
            $comment->commentText = $row['commentText'];
		    $comment->dateTime = $row['dateTime'];
            array_push($array_comments, $comment);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_comments;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get comments: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>