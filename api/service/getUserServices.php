<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/subCategory.php');
    error_reporting(0);	
    
    $sql = 'select 
        service.id,
        service.title,
        service.description,
        service.hourlyCost,
        service.minimumHours,
        service.active,
        service.profileHits,
        user.id as userId,
        user.username,
        user.email,
        user.travelRadius,
        from
        service inner join user
        on service.userId = user.id
    ';
    $array_service = array();

	if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $service = new Service;
            $service->id = $row['id'];
            $service->title = $row['title'];
            $service->description = $row['description'];
            $service->hourlyCost = $row['hourlyCost'];
            $service->minimumHours = $row['minimumHours'];
            $service->profileHits = $row['profileHits'];
           
            $user = new User;
            $user->id = $row['userId'];
            $user->name = $row['username'];
            $user->email = $row['email'];
            $user->travelRadius = $row['travelRadius'];

            $service->user = $user;
            array_push($array_service, $subcategory);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_category;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get User Services Detail: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>