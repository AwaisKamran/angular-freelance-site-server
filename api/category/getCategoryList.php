<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/category.php');
    error_reporting(0);	
    
    $sql = 'select * from category';

    $array_category = array();

	if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $category = new Category;
            $category->id = $row['id'];
            $category->name = $row['name'];
		    $category->description = $row['description'];
            array_push($array_category, $category);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_category;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get category: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>