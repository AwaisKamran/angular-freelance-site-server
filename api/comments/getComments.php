<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/comment.php');
    error_reporting(0);	
    
    $sql = 'select comments.id, comments.commentDescription, (select name from user where user.id = comments.userId) as userName from comments where comments.assignmentId ='. $_GET['assignmentId'];
    $array_comment = array();

	if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $comment = new Comment;
            $comment->id = $row['id'];
            $comment->commentDescription = $row['commentDescription'];
            $comment->user = $row['userName'];
            array_push($array_comment, $comment);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_comment;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get comment: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>