<?php

    session_start();
    include_once "../libraries/boilerplate.php";
    include_once "../resources/models/user.php";
    include_once "../resources/models/tasks.php";
    include_once "../resources/controllers/taskReader.php";
    include_once "../resources/controllers/taskSubmitter.php";

    if(array_key_exists("form", $_POST) && array_key_exists("openTask", $_SESSION))
    {
        $form = $_POST["form"];

        $user = unserialize($_SESSION["User"]);
        $task = $_SESSION["openTask"];
        $setTask = $_SESSION["openSetTask"];

        $taskReader = new TaskReader($task);

        $taskSubmitter = new TaskSubmitter($form, $taskReader, $user);

        $results = $taskSubmitter->checkAnswers();
        //Submit to database
        $uploadStatus = $taskSubmitter->submit($setTask);

        var_dump($results); 

        unset($_SESSION["openTask"]);
        unset($_SESSION["openSetTask"]);

    }
?>