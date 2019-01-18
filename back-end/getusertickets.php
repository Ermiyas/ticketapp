<?php

if (isset($_POST['getUserTasks'])) {

    session_start();
    include 'jsonmsg.php';

    if (isset($_SESSION['userId'])) {

        include 'db_connect.php';
        $conn = OpenCon();

        $owner = $_SESSION['userUid'];
        $done = 0;

        $sql = "SELECT * FROM tasks WHERE owner=? and done=?";
        $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                msg(false, mysqli_error($conn));
                exit();
            }
            else {
                $myTasks = [];
                mysqli_stmt_bind_param($stmt, "si", $owner, $done);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                    $task = array("title" => $row["title"], "id" => (int)$row["id"], "value" => $row["value"], "priority" => (int)$row["priority"], "done" => (int)$row["done"]);
                    array_push($myTasks, $task);
                }
                echo json_encode($myTasks);
                
                exit();
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