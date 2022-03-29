<?php
    session_start();
    include_once "../libraries/boilerplate.php";
    include_once "../resources/models/user.php";

    $user = unserialize($_SESSION["User"]);



    echo $blade->run("signedup", array("user" => $user));
?>
