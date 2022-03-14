<?php
    session_start();
    include_once "../libraries/boilerplate.php";
    include_once "../resources/models/usermodel.php";

    if(array_key_exists("User", $_SESSION)){

        $user = unserialize($_SESSION["User"]);

        echo $blade->run("dashboard", array("page"=>"dashboard", "fullName"=>$user->fullName));

    }
    else{
        header("Location: index.php");
    }

?>
