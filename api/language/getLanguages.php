<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/language.php');
    include('../../model/level.php');
    error_reporting(0);	
    
    $sql = 'select language.id, language.name, language.symbol, level.id as levelId, level.name as levelName, level.payrate as levelPayrate from language inner join level on language.level = level.id';

    $array_language = array();

	if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $language = new Language;
            $language->id = $row['id'];
            $language->name = $row['name'];
            $language->symbol = $row['symbol'];
            
            $level = new Level;
            $level->id = $row['levelId'];
            $level->name = $row['levelName'];
            $level->payrate = $row['levelPayrate'];

            $language->level = $level;
            array_push($array_language, $language);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_language;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get language: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>