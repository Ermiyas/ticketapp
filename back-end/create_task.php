<?php

include 'jsonmsg.php'; 

if (isset($_POST['createTask'])) {

session_start();

if (isset($_SESSION['userUid'])) {

    include 'db_connect.php';
    $conn = OpenCon();

    $type = "ticket";
    $title = $_POST['title'];
    $value = $_POST['value'];
    $priority = (int)$_POST['priority'];
    $owner = $_SESSION['userUid'];
    $comments = json_encode([]);
    $done = 0;

    if (empty($title) || empty($value) || empty($priority)) {
        msg(false, "emtpyfields");
        exit();
    }
    else { 

        $sql = "INSERT INTO tasks (type, title, value, priority, owner, done, comments) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            msg(false, mysqli_error($conn));
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "sssssis", $type, $title, $value, $priority, $owner, $done, $comments);
            mysqli_stmt_execute($stmt);
        }
        msg(true);
        

    }
}
else {
    msg(false, "not logged in");
    exit();
}

}
else{
    msg(false, "none request");
}  
    
    