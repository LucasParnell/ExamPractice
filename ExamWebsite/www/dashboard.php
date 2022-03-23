<?php
    session_start();
    include_once "../libraries/boilerplate.php";
    include_once "../resources/models/user.php";
    include_once "../resources/models/tasks.php";

    if(array_key_exists("User", $_SESSION)){

        $user = unserialize($_SESSION["User"]);
        $task = new Tasks();
        echo $blade->run("dashboard", array("page"=>"dashboard", "user"=>$user, "tasks"=>$task->getStudentTasks($user)));

    }
    else{
        header("Location: index.php");
    }

?>
