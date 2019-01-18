<?php

include 'jsonmsg.php'; 

if (isset($_POST['updateTask'])) {

    session_start();

    if (isset($_SESSION['userUid'])) {

        include 'db_connect.php';
        $conn = OpenCon();

        $taskInfo = json_decode($_POST['taskInfo'], true);
        $owner = $_SESSION['userUid'];
        
        if (array_key_exists("title",$taskInfo) && array_key_exists("value",$taskInfo) && array_key_exists("priority",$taskInfo) && array_key_exists("done",$taskInfo) && array_key_exists("id",$taskInfo)) {
           
            $title = $taskInfo["title"];
            $value = $taskInfo["value"];
            $priority = $taskInfo["priority"];
            $done = $taskInfo["done"];
            $id = $taskInfo["id"];
            
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
                    if ((int)$row["id"] === $taskInfo["id"]) {

                        $sql2 = "UPDATE tasks SET title=?, value=?, priority=?, done=? WHERE id=?";
                        $stmt2 = mysqli_stmt_init($conn);
                        if (!mysqli_stmt_prepare($stmt2, $sql2)) {
                            msg(false, mysqli_error($conn));
                            exit();
                        }
                        else {
                            mysqli_stmt_bind_param($stmt2, "ssiii", $title, $value, $priority, $done, $id);
                            mysqli_stmt_execute($stmt2);
                            msg(true);
                            exit();
                        }

                    }
                }

                msg(false, "you dont have permission to do that");
                exit();

            }

        }
        else {
            msg(false, "incorrect input");
            exit();
        }

    }
    else {
        msg(false, "not logged in");
        exit();
    }

}
else {
    msg(false, "none request");
}  