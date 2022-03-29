<?php
    session_start();
    include_once "../libraries/boilerplate.php";
    include_once "../resources/models/user.php";
    include_once "../resources/models/tasks.php";
    include_once "../resources/models/feedback.php";
    include_once "../resources/models/leaderboard.php";
    include_once "../resources/models/teachingGroups.php";
    if(array_key_exists("User", $_SESSION)){

        $user = unserialize($_SESSION["User"]);

        if($user->getUserType()=="student"){
            $tasks = new Tasks();
            $feedback = new Feedback($tasks);
            $leaderboard = new Leaderboard($user);
            echo $blade->run("studentdashboard", array("page"=>"dashboard",
                                                "user"=>$user,
                                                "tasks"=>$tasks->getStudentTasks($user, false),
                                                "feedback"=>$feedback->getFeedbackTasks($user),
                                                "leaderboard"=>$leaderboard,
                                                "debug"=>$SITE_DEBUG_ENABLED));
        }
        else{
            $teachingGroups = new TeachingGroups($user);
            echo $blade->run("teacherdashboard", array("user"=>$user,"teachingGroups"=>$teachingGroups, "debug"=>$SITE_DEBUG_ENABLED));
        }
    }
    else{
        header("Location: index.php");
    }

?>
