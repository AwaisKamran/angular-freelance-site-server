<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/service.php');
    include('../../model/user.php');
    error_reporting(0);	

    $filter = '';
    $data = json_decode(file_get_contents("php://input"), true)['data'];
    $categoryId = $data['categoryId'];
    $subCategoryId = $data['subCategoryId'];
    $country = $data['country'];
    $city = $data['city'];
    $hasFilter = false;

   if($categoryId){
        $filter.= 'service.categoryId ='.$categoryId;
        $hasFilter = true;
   } 

   if($subCategoryId) {
       if($hasFilter) $filter.= " && ";
       $filter.= 'service.subCategoryId ='.$subCategoryId;
       $hasFilter = true;
   }

   if($country) {
       if($hasFilter) $filter.= " && ";
       $filter.= 'user.country ='.$country;
       $hasFilter = true;
   }

   if($city) {
        if($hasFilter) $filter.= " && ";
        $filter.= "user.city='$city'";  
        $hasFilter = true;
   }
    
    $sql = 'select 
    service.id,
    service.title,
    service.description,
    service.hourlyCost,
    service.minimumHours,
    service.active,
    service.profileHits,
    service.categoryId,
    user.id as userId,
    user.username,
    user.email,
    user.travelRadius,
    user.country,
    user.city
    from
    service inner join user
    on service.userId = user.id';

    if($hasFilter) {
        $sql.=" where ";
        $sql.= $filter;
    }

    $array_service = array();

	if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $service = new Service;
            $service->id = $row['id'];
            $service->title = $row['title'];
            $service->description = $row['description'];
            $service->categoryId = $row['categoryId'];
            $service->hourlyCost = $row['hourlyCost'];
            $service->minimumHours = $row['minimumHours'];
            $service->profileHits = $row['profileHits'];
           
            $user = new User;
            $user->id = $row['userId'];
            $user->name = $row['username'];
            $user->email = $row['email'];
            $user->travelRadius = $row['travelRadius'];
            $user->country = $row['country'];
            $user->city = $row['city'];

            $service->user = $user;
            array_push($array_service, $service);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_service;
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