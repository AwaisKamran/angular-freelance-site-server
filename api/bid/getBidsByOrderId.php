<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/bid.php');
    error_reporting(0);	
    
    $sql = 'select 
    id,
    orderId,
    bidDescription,
    timeRequired,
    proposedBudget,
    proposedBy,
    (select username from user where user.id = proposedBy) as userName,
    accepted
    from bids where orderId ='. $_GET['orderId'];

    $array_bid = array();

	if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $bid = new Bid;
            $bid->id = $row['id'];
            $bid->orderId = $row['orderId'];
            $bid->bidDescription = $row['bidDescription'];
            $bid->timeRequired = $row['timeRequired'];
            $bid->proposedBudget = $row['proposedBudget'];
            $bid->proposedBy = $row['proposedBy'];
            $bid->accepted = $row['accepted'];
            $bid->userName = $row['userName'];
            array_push($array_bid, $bid);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_bid;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get bids: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>