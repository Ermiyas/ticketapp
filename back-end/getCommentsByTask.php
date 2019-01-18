<?php

include 'jsonmsg.php'; 

if (isset($_POST['getComments'])) {

session_start();

if (isset($_SESSION['userUid'])) {

    include 'db_connect.php';
    $conn = OpenCon();

    $id = $_POST['id'];
    $role = $_SESSION['userRole'];
 

    if (empty($id)) {
        msg(false, "emtpyfields");
        exit();
    }
    else { 

        $sql = "SELECT * FROM comments WHERE task=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            msg(false, mysqli_error($conn));
            exit();
        }
        else {
            $taskComments = [];
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while ($row = mysqli_fetch_assoc($result)) {
                $comment = array("id" => $row["id"], "value" => $row["value"], "owner" => $row["owner"]);
                array_push($taskComments, $comment);
            }
            
            $sql2 = "SELECT * FROM tasks WHERE id=?";
            $stmt2 = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt2, $sql2)) {
                msg(false, mysqli_error($conn));
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt2, "i", $id);
                mysqli_stmt_execute($stmt2);
                $result2 = mysqli_stmt_get_result($stmt2);
                if ($row2 = mysqli_fetch_assoc($result2)) {
                    $order = json_decode($row2["comments"]);
                }
                else {
                    msg(false, "no order found");
                    exit();
                }
                $comments = array();
                for ($i=0; $i < sizeof($order); $i++) {
                    for ($a=0; $a < sizeof($taskComments); $a++) {
                        if ($taskComments[$a]["id"] === $order[$i]) {
                            array_push($comments, $taskComments[$a]);
                            break;
                        }
                    }
                }
                echo json_encode($comments);


            }
            
            exit();
        }
        

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