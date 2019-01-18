<?php
if (isset($_POST['register'])) {

    include 'jsonmsg.php';
    include 'db_connect.php';
    $conn = OpenCon();

    $username = $_POST['username'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwdrepeat'];
    $role = $_POST['role'];
    $stack = json_encode([]);


    if (empty($username) || empty($role) || empty($password) || empty($passwordRepeat)) {
        msg(false, "emptyfileds");
        exit();
    }
    elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        msg(false, "invalid username");
        exit();
    }
    elseif ($password !== $passwordRepeat) {
        msg(false, "passwords dont match");
        exit();
    }
    else {

        $sql = "SELECT username FROM users WHERE username=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            msg(false, "sql error");
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0) {
                msg(false, "username taken");
                exit();
            }
            else {

                $sql = "INSERT INTO users (username, password, role, stack) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    msg(false, mysqli_error($conn));
                    exit();
                }
                else {
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, "ssss", $username, $hashedPwd, $role, $stack);
                    mysqli_stmt_execute($stmt);
                    msg(true);
                    exit();
                }

            }
        }

    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
}
else {
    msg(false, "not post");
    exit();
}