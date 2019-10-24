<?php
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/category.php');
    include('../../model/subCategory.php');
    error_reporting(0);	
    
    $data = json_decode(file_get_contents("php://input"), true)['data'];
    $userId = $data['userId'];

    $sql = "select 
    categoryRecords.id,
    categoryRecords.name,
    categoryRecords.description,
    categoryRecords.createdBy,
    categoryRecords.createdDate,

    subcategory.name as subcategoryName,
    subcategory.description as subCategoryDescription

    from 
    (   
        select 
        category.id, 
        category.name,
        category.description,
        category.createdBy,
        category.createdDate, 
        usercategories.subCategory
        from usercategories inner join catgeory 
        on usercategories.categoryId = category.id 
         &&  where userId='$userId'
    ) as categoryRecords inner join subcategory
    on categoryRecords.subCategory = subcategory.id";

    $array_categories = array();

	if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $category = new Category;
            $category->id = $row['id'];
            $category->name = $row['name'];
            $category->description = $row['description'];
            $category->createdBy = $row['createdBy'];
            $category->createdDate = $row['createdDate'];

            $subCategory = new SubCategory;
            $subCategory->name = $row['subcategoryName'];
            $subCategory->description = $row['subCategoryDescription'];

            $category->subCategory = $subCategory;
            array_push($array_categories, $category);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_categories;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Add User Categories: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>