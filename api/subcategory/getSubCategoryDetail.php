<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/category.php');
    include('../../model/subCategory.php');
    error_reporting(0);	

    $sql = 'select 
        subcategory.id as subCategoryId,
        subcategory.subCategoryName,
        category.id as categoryId,
        category.categoryName as categoryName
        from
        subcategory inner join category
        on subcategory.categoryId = category.id
    ';
    $array_subcategory = array();

	if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $subcategory = new SubCategory;
            $subcategory->id = $row['subCategoryId'];
            $subcategory->subCategoryName = $row['subCategoryName'];
           
            $category = new Category;
            $category->id = $row['categoryId'];
            $category->categoryName = $row['categoryName'];

            $subcategory->category = $category;
            array_push($array_subcategory, $subcategory);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_subcategory;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get Sub-Category Detail: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>