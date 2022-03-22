<?php
    session_start();
    include_once "../libraries/boilerplate.php";
    include_once "../resources/models/usermodel.php";
    include_once "../resources/models/taskmodel.php";
    include_once "../resources/controllers/taskBuilder.php";

    $user = unserialize($_SESSION["User"]); 
    $tasks = new Tasks();
    $tasks = $tasks->getStudentTasks($user);

    $taskId = $_POST["taskId"];

    $task = [];


    //Find and set task
    for($i=0; $i<count($tasks); $i++){
        if($tasks[$i]["id"]==$taskId){
            $task = $tasks[$i];
        }
    }

    $taskBuilder = new TaskBuilder($task);

    $taskBuilder->readTaskFile();

    $questions = $taskBuilder->getQuestions();

    echo $blade->run("ajax.taskmodal", array("user" => $user, "task"=>$task, "questions"=>$questions));

?>