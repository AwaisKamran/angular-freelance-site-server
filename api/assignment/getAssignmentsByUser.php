<?php
    include('../../cors.php');
    include('../../connection.php');
    include('../../model/error.php');
    include('../../model/success.php');
    include('../../model/assignment.php');
    include('../../model/level.php');
    include('../../model/language.php');
    include('../../model/user.php');
    error_reporting(0);

    $sql = 'select 
        assignmentRecords.id,
        assignmentRecords.title,
        assignmentRecords.description,
        assignmentRecords.type,
        assignmentRecords.assignmentInternalComment,
        assignmentRecords.active,
        assignmentRecords.status,
        assignmentRecords.dueDate,
        assignmentRecords.createdDate,
        assignmentRecords.assignedTo,
        assignmentRecords.languageName,
        assignmentRecords.languageSymbol,
        assignmentRecords.languageRate,
        assignmentRecords.words,
        user.id as userId,
        user.name as userName  
        from 
        (
            select   
            assignment.id, 
            assignment.title,
            assignment.description,
            assignment.type,
            assignment.assignmentInternalComment,
            assignment.active,
            assignment.status,
            assignment.dueDate,
            assignment.createdDate,
            assignment.assignedTo,
            assignment.words,
            language.name as languageName,
            language.symbol as languageSymbol,
            (
                select level.payrate from level where id = language.level) as languageRate
                from 
                assignment inner join language
                on assignment.language = language.id
            ) assignmentRecords inner join user
        on assignmentRecords.assignedTo = user.id where assignmentRecords.assignedTo = '. $_GET['id'];

    $result = mysqli_query($conn, $sql);
    $assignment = new Assignment;

	if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $assignment->id = $row['id'];
            $assignment->title= $row['title'];
            $assignment->description= $row['description'];
            $assignment->type= $row['type'];
            $assignment->assignmentInternalComment= $row['assignmentInternalComment'];
            $assignment->active= ($row['active'] === '0'? false: true);
            $assignment->status= $row['status'];
            $assignment->dueDate= $row['dueDate'];
            $assignment->words= $row['words'];
            $assignment->createdDate= $row['createdDate'];
            $assignment->assignedTo= $row['assignedTo'];

            $language = new Language;
            $language->name= $row['languageName'];
            $language->symbol= $row['languageSymbol'];

            $level = new Level;
            $level->payrate = $row['languageRate'];
            
            $language->level = $level;

            $user = new User;
            $user->id = $row['userId'];
            $user->name = $row['userName'];

            $assignment->language = $language;
            $assignment->assignedTo = $user;
        }

        $success = new Success;
        $success->success = true;
        $success->data = $assignment;
        echo json_encode($success);
	} 
	else {
        $error = new CustomError;
        $error->description = "Get Assignment Listings: ". mysqli_error($conn);
        $error->success = false;
        echo json_encode($error);
    }

    mysqli_close($conn);
?>