<?php
    session_start();
    include_once "../libraries/boilerplate.php";
    include_once "../resources/models/usermodel.php";

    $user = unserialize($_SESSION["User"]);



    echo $blade->run("loggedin", array("user" => $user));
?>
