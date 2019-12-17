<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/Order.php');
    include('../../model/Service.php');
    include('../../model/User.php');
    error_reporting(0);	
    
    $sql = 'select 
        orders.id,
        orders.serviceId,
        orders.hoursRequired,
        orders.budget,
        orders.orderInstructions,
        orders.status,
        orders.orderCreated,
        orders.orderCreatedBy as userId,

        service.title,
        service.description,
        service.hourlyCost,
        service.minimumHours,


        (select username from user where id = orders.orderCreatedBy) as userName,
        (select userId from service where id = orders.serviceId) as freelancerId
        
        from orders inner join service
        on orders.serviceId = service.id
        where service.userId ='. $_GET['userId'] .' && orders.id='. $_GET['orderId'];

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
            $order->freelancerId = $row['freelancerId'];

            $service = new Service;
            $service->title = $row['title'];
            $service->description = $row['description'];
            $service->hourlyCost = $row['hourlyCost'];
            $service->minimumHours = $row['minimumHours'];

            $user = new User;
            $user->id = $row['userId'];
            $user->username = $row['userName'];

            $order->service = $service;
            $order->user = $user ;
        }

        $success = new Success;
        $success->success = true;
        $success->data = $order;
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