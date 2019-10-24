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
        assignmentRecords.reservedDate,
        assignmentRecords.assignedTo,
        assignmentRecords.languageId,
        assignmentRecords.languageName,
        assignmentRecords.languageSymbol,
        assignmentRecords.languageRate,
        assignmentRecords.words,
        assignmentRecords.clientName,
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
            assignment.reservedDate,
            assignment.assignedTo,
            assignment.words,
            assignment.clientName,
            language.id as languageId,
            language.name as languageName,
            language.symbol as languageSymbol,
            (select level.payrate from level where id = language.level) as languageRate
            from 
            assignment inner join language
            on assignment.language = language.id
        ) assignmentRecords left outer join user
        on assignmentRecords.assignedTo = user.id';
        
    $statusAdded = false;
    if(isset($_GET['status']) && !empty($_GET['status'])){
        $sql.=' where assignmentRecords.status ='.$_GET['status'];
        $statusAdded = true;
    }

    if(isset($_GET['writer']) && !empty($_GET['writer'])){
        if($statusAdded) $sql.= ' &&';
        else $sql.= ' where';
        $sql.=' user.name LIKE "%'.$_GET['writer'].'%"';
    }

    $sql.= ' order by assignmentRecords.id desc';

    $array_users = array();
    $result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $assignment = new Assignment;
            $assignment->id = $row['id'];
            $assignment->title= $row['title'];
            $assignment->description= $row['description'];
            $assignment->type= $row['type'];
            $assignment->assignmentInternalComment= $row['assignmentInternalComment'];
            $assignment->active= ($row['active'] === '0'? false: true);
            $assignment->status= $row['status'];
            $assignment->dueDate= $row['dueDate'];
            $assignment->reservedDate= $row['reservedDate'];
            $assignment->words= $row['words'];
            $assignment->createdDate= $row['createdDate'];
            $assignment->assignedTo= $row['assignedTo'];
            $assignment->clientName= $row['clientName'];

            $language = new Language;
            $language->id= $row['languageId'];
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
            array_push($array_users, $assignment);
        }

        $success = new Success;
        $success->success = true;
        $success->data = $array_users;
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