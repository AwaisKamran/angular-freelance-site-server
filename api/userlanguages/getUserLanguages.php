<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/userLanguages.php');
    include('../../model/user.php');
    include('../../model/language.php');
    error_reporting(0);	
    

    $sql = 'select 
        languageRecords.languageId,
        languageRecords.languageName,
        user.id,
        user.name    

        from 
        (
            select 
            userlanguage.userId,
            language.id as languageId,
            language.name as languageName
            from  userlanguage inner join language 
            on userlanguage.languageId = language.id
        ) 
        languageRecords inner join user
        on languageRecords.userId = user.id 
    ';

    $array_users = array();

	if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $user = new User;
            $user->id = $row['id'];
            $user->name = $row['name'];

            $language = new Language;
            $language->id = $row['languageId'];
            $language->name = $row['languageName'];

            $userLanguages = new UserLanguage;    
            $userLanguages->user = $user;
            $userLanguages->language = $language;

            array_push($array_users, $userLanguages);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_users;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get User Languages Listings: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>