<?php

include 'jsonmsg.php'; 

if (isset($_POST['changeOrder'])) {

    session_start();

    if (isset($_SESSION['userUid'])) {

        include 'db_connect.php';
        $conn = OpenCon();

        $newOrder = json_encode($_POST['newOrder']);
        $owner = $_SESSION['userUid'];

        $sql = "UPDATE users SET stack=? WHERE username=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            msg(false, mysqli_error($conn));
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "ss", $newOrder, $owner);
            mysqli_stmt_execute($stmt);
            msg(true);
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