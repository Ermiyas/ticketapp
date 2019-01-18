<?php

include 'jsonmsg.php'; 

if (isset($_POST['createComment'])) {

session_start();

if (isset($_SESSION['userUid'])) {

    include 'db_connect.php';
    $conn = OpenCon();

    $value = $_POST['value'];
    $task = $_POST['task'];
    $owner = $_SESSION['userUid'];

    if (empty($value)) {
        msg(false, "emtpyfields");
        exit();
    }
    else { 

        $sql = "INSERT INTO comments (value, owner, task) VALUES (?, ?, ?)";
        
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            msg(false, mysqli_error($conn));
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "ssi", $value, $owner, $task);
            mysqli_stmt_execute($stmt);
        }

        $sql2 = "SELECT * FROM tasks WHERE id=?";
        $stmt2 = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt2, $sql2)) {
            msg(false, mysqli_error($conn));
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt2, "i", $task);
            mysqli_stmt_execute($stmt2);
            $result2 = mysqli_stmt_get_result($stmt2);
            if ($row2 = mysqli_fetch_assoc($result2)) {
                $order = json_decode($row2["comments"]);
            }
            else {
                msg(false, "no order found");
                exit();
            }

            $sql3 = "SELECT * FROM comments ORDER BY ID DESC LIMIT 1";
            $result3 = $conn->query($sql3);
            $row3 = mysqli_fetch_assoc($result3);


            array_push($order, (int)$row3["id"]);
            $order = json_encode($order);
               
            $sql4 = "UPDATE tasks SET comments=? WHERE id=?";
            $stmt4 = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt4, $sql4)) {
            msg(false, mysqli_error($conn));
            exit();
            }
            else {
                mysqli_stmt_bind_param($stmt4, "si", $order, $task);
                mysqli_stmt_execute($stmt4);
            }

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
    
    