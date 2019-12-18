<?php
    ini_set('max_execution_time', 300);
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/order.php');
    error_reporting(0);	
    
    $sql = 'select 
        orders.id,
        orders.serviceId,
        orders.hoursRequired,
        orders.budget,
        orders.orderInstructions,
        orders.status,
        orders.orderCreated,
        orders.orderCreatedBy,
        orders.categoryId,

        (select userId from service where id = orders.serviceId) as userId,
        (select username from user where user.id = orders.orderCreatedBy) as userName,
        (select categoryName from category where category.id = orders.categoryId) as categoryName,
        (select count(*) from bids where orderId = orders.id) as bidCount

        from orders where orders.orderCreatedBy = '. $_GET['userId'];
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
            $order->categoryId = $row['categoryId'];
            $order->bidCount = $row['bidCount'];
            $order->freelancerId = $row['userId'];
            array_push($array_order, $order);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_order;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get Order History Detail: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>