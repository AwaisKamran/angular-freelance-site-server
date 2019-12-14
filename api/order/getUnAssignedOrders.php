<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/Order.php');
    error_reporting(0);	
    
    $sql = 'select 
        id,
        serviceId,
        hoursRequired,
        budget,
        orderInstructions,
        status,
        orderCreated,
        orderCreatedBy,
        (select username from user where user.id = orders.orderCreatedBy) as userName,
        (select categoryName from category where category.id = orders.categoryId) as categoryName,
        (select count(*) from bids where orderId = orders.id) as bidCount
        from orders where serviceId IS NULL
    ';
    $array_order = array();

	if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $order = new Order;
            $order->id = $row['id'];
            $order->serviceId = $row['serviceId'];
            $order->hoursRequired = $row['hoursRequired'];
            $order->budget = $row['budget'];
            $order->orderInstructions = $row['orderInstructions'];
            $order->status = $row['status'];
            $order->orderCreated = $row['orderCreated'];
            $order->orderCreatedBy = $row['orderCreatedBy'];
            $order->userName = $row['userName'];
            $order->categoryName = $row['categoryName'];
            $order->bidCount = $row['bidCount'];
            array_push($array_order, $order);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_order;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get Unassigned Order Detail: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>