<?php

include_once "../libraries/utilities.php";

class Feedback{
    //Take tasks modal
    //Check if any tasks are not in the feedback table
    //Return these tasks

    function __construct($tasks){
        $this->tasks = $tasks;
    }

    function getFeedbackTasks($user){

        $db = Utils::connectDatabase();

        $feedbackTasks = [];

        $allTasks = $this->tasks->getStudentTasks($user, true);

        for($i=0; $i<count($allTasks); $i++){
            $task = $allTasks[$i];
            //Check completed tasks
            $sql = <<<SQL
                SELECT `ID` FROM `CompletedTasks` WHERE `SetTaskID` = {$task["setTaskId"]} AND `StudentID` = {$user->getUserId()}
            SQL;

            $result = $db->query($sql);

            while($row = $result->fetch_assoc()){
                $sql = <<<SQL
                    SELECT `ID` FROM `TaskFeedback` WHERE `CompletedTaskID` = {$row["ID"]}
                    SQL;
                
                $result = $db->query($sql);
                if(!$result->fetch_assoc()){
                    array_push($feedbackTasks, $allTasks[$i]);
                }
            }

        }

        return $feedbackTasks;  
    }

}

?>