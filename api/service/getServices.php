<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/user.php');
    include('../../model/service.php');
    include('../../model/category.php');
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
        service.userId,
        (select username from user where id = service.userId) as username,
        service.categoryId,
        (select categoryName from category where id = service.categoryId) as categoryName,
        service.subCategoryId,
        (select subCategoryName from subcategory where id = service.subCategoryId) as subCategoryName,
        from service
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
            $user->username = $row['username'];

            $category = new Category;
            $category->id = $row['categoryId'];
            $category->categoryName = $row['categoryName'];

            $subCategory = new SubCategory;
            $subCategory->id = $row['subCategoryId'];
            $subCategory->subCategoryName = $row['subCategoryName'];

            $service->user = $user;
            $service->category = $category;
            $service->subcategory = $subCategory;
            array_push($array_service, $service);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_category;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get User Services: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>