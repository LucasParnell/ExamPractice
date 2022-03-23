<?php
    session_start();
    include_once "../libraries/boilerplate.php";
    
    if(array_key_exists("User", $_SESSION)){
        header("Location: dashboard.php");
    }else{
        echo $blade->run("home", array("page"=>"home"));
    }
?>
