<?php
    session_start();
    include_once "../libraries/boilerplate.php";
    include_once "../resources/controllers/logincontroller.php";
    if(array_key_exists("User", $_SESSION)){
        session_destroy();
        echo $blade->run("logout");
    }
    else{
        echo $blade->run("home");
    }
 ?>