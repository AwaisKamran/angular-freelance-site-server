<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/subCategory.php');
    error_reporting(0);	
    
    $sql = 'select * from subcategory';
    $array_subcategory = array();

	if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $subcategory = new SubCategory;
            $subcategory->id = $row['id'];
            $subcategory->subcategoryName = $row['subcategoryName'];
            $subcategory->category = $row['categoryId'];
            $subcategory->createdDate = $row['createdDate'];
            array_push($array_subcategory, $subcategory);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_category;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get Sub-Category: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>