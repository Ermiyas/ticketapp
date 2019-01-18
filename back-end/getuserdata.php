<?php

include 'jsonmsg.php';

if (isset($_POST['getUserData'])) {

session_start();

if (isset($_SESSION['userId'])) {

    include 'db_connect.php';
    $conn = OpenCon();
    $myObj = array("userId" => $_SESSION['userId'], 
        "name" => $_SESSION['userUid'],
        "role" => $_SESSION['userRole'],
        "stack" => $_SESSION['userStack'],
);


    $myJSON = json_encode($myObj);

    echo $myJSON;


}
else {
    msg(false,"not logged in");
    exit();
}

}