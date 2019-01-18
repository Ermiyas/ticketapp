<?php

if (isset($_POST['getAllTasks'])) {

session_start();

include 'jsonmsg.php';

if (isset($_SESSION['userId'])) {

    include 'db_connect.php';
    $conn = OpenCon();

    $role = $_SESSION['userRole'];
    $stack = json_decode($_SESSION['userStack']);

    $owner = $_SESSION['userUid'];
    $done = 0;

    if ($role == 'burzo') {

        $sql = "SELECT * FROM tasks WHERE owner=? and done=?";
        $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                msg(false, mysqli_error($conn));
                exit();
            }
            else {
                $allTasks = [];
                mysqli_stmt_bind_param($stmt, "si", $owner, $done);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                    $task = array("title" => $row["title"], "id" => (int)$row["id"], "value" => $row["value"], "priority" => (int)$row["priority"], "done" => (int)$row["done"]);
                    array_push($allTasks, $task);
                }
                echo json_encode($allTasks);
                
                exit();
            }

    }
    elseif ($role == 'proletar') {
        $inOrderTasks = [];
        $allTasks = [];
        $remainder = [];

        $sql = "SELECT * FROM tasks WHERE done=0";
        $result = $conn->query($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $task = array("title" => $row["title"], "id" => (int)$row["id"], "value" => $row["value"], "priority" => (int)$row["priority"], "done" => (int)$row["done"]);
            array_push($allTasks, $task);
        }
        
        for ($i=0; $i < sizeof($allTasks); $i++) {
            array_push($remainder, $allTasks[$i]);
        }

        for ($i=0; $i < sizeof($stack); $i++) {
            for ($a=0; $a < sizeof($allTasks); $a++) {
                if ($stack[$i] === $allTasks[$a]["id"]) {
                    array_unshift($inOrderTasks, $allTasks[$a]);
                    unset($remainder, $allTasks[$a]);
                    break;
                }
            }
        }

        for ($i=0; $i < sizeof($remainder); $i++) {
            array_push($inOrderTasks, $remainder[$i]);
        }

        echo json_encode($inOrderTasks);

    }
    else {
        msg(false, "incorrect user profile");
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