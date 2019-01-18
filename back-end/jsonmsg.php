<?php

function msg($success,$info="")
{
$myObj = array("success" => $success,"error" => $info);
$myJSON = json_encode($myObj);
echo $myJSON;
}

?>