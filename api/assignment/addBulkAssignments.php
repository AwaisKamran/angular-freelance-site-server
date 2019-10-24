<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    error_reporting(0);

    require('../../spreadsheet-reader/php-excel-reader/excel_reader2.php');
	require('../../spreadsheet-reader/SpreadsheetReader.php');

    $target_dir = "../../uploads/bulk-assignments";
    $target_file = $target_dir . '/bulk-assignments.xlsx';
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if($imageFileType === 'xlsx') {
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

        $Reader = new SpreadsheetReader('../../uploads/bulk-assignments/bulk-assignments.xlsx');
        foreach ($Reader as $key=>$Row)
        {
            if($key != 0){
                $title =  $Row[0];
                $description = $Row[1];
                $type = $Row[2];
                $words = $Row[3];
                $active = $Row[4];
                $language = $Row[5];
                $createdDate = $Row[6];
                $createdBy = $Row[7];
                $status = '1';

                $sql = "INSERT INTO assignment ".
                "(title, description, type, words, active, language, createdDate, createdBy, status) ".
                "VALUES ('$title', '$description','$type', '$words', '$active', '$language', '$createdDate', '$createdBy', '$status')";
                mysqli_query($conn, $sql);
            }
        }

        $success = new Success;
        $success->success = true;
        $success->data = null;
        echo json_encode($success);
    }
    else{
        $error = new CustomError;
        $error->description = "Error: Bulk Assignment Uploading: Only .xlsx files allowed.";
        $error->success = false;
        echo json_encode($error);
    }
?>