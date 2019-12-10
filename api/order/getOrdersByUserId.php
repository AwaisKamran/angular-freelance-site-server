<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/Order.php');
    error_reporting(0);	
    
    $sql = 'select 
        orders.id,
        orders.serviceId,
        orders.hoursRequired,
        orders.budget,
        orders.orderInstructions,
        orders.status
        from orders inner join service
        on orders.serviceId = service.id
        where service.userId ='. $_GET['userId'];

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
            array_push($array_order, $order);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_order;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get User Order Detail: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>