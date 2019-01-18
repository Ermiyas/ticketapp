<?php

if (isset($_POST['login'])) {
    
    include 'db_connect.php';
    include 'jsonmsg.php';
 
    $conn = OpenCon();

    $username = $_POST['username'];
    $password = $_POST['pwd'];

    if (empty($username) || empty($password)) {
        msg(false, "emtpyfields");
        exit();
    }
    else {
        $sql = "SELECT * FROM users WHERE username=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            msg(false, "sqlerror");
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $pwdcheck = password_verify($password, $row['password']);
                if ($pwdcheck == false) {
                    msg(false, "wrongpwd");
                    exit();
                }
                elseif ($pwdcheck == true) {
                    session_start();
                    $_SESSION['userId'] = $row['id'];
                    $_SESSION['userUid'] = $row['username'];
                    $_SESSION['userRole'] = $row['role'];
                    $_SESSION['userStack'] = $row['stack'];

                    msg(true);
                    exit();

                }
                else {
                    msg(false, "wrongpwd");
                    exit();
                }
            }
            else {
                msg(false, "nouser");
                exit();
            }
        }
    }
}
else {
    msg(false, "index");
    exit();
}