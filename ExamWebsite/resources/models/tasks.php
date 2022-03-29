<?php
    include_once "../libraries/utilities.php";
    include_once "../resources/models/completedtask.php";
    class Tasks {

        //Write about views on OOP

        function getStudentTasks($user, $getAll){
            $sql = "";

            $userId = $user->getUserId();
            //First, get TeachingGroups of the user

            $sql = <<<SQL
            SELECT `TeachingGroupID` FROM `TeachingGroupStudents` WHERE `StudentID` = $userId;
            SQL;

            $db = Utils::connectDatabase();

            $result = $db->query($sql);


            $resultArray = $result->fetch_all();

            //Final array for tasks
            $tasks = [];

            for($i=0; $i<count($resultArray); $i++){
                $teachingGroup = $resultArray[$i][0];

                //Get all SetTasks for TeachingGroup
                $sql = <<<SQL
                SELECT * FROM `SetTasks` WHERE `TeachingGroupID` = $teachingGroup;
                SQL;
                
                $result = $db->query($sql);

                

                while ($row = $result->fetch_assoc()) {
                    //Start storing data
                    $today = new DateTime();

                    $taskDueDate = new DateTime($row["DueDate"]);
                    
                    $taskDueDateStr = $taskDueDate->format("d/m/Y");
                    $taskTeacherId = $row["TeacherID"];
                    $setTaskId = $row["ID"];
                    $taskId = $row["TaskID"];

                    //Before going further, check if the task is completed using the ID
                    if(!CompletedTask::checkCompleted($setTaskId, $user->getUserId()) || $getAll){

                        $taskOverdue = ($today > $taskDueDate);
                        
                        //PLACEHOLDER
                        //Can be improved in the future
                        $teacherName = $db->query("SELECT `TeacherName` FROM `Teachers` WHERE `ID` = $taskTeacherId")->fetch_all()[0][0];

                        //Get Task Data
                        $sql = <<<SQL
                        SELECT * FROM `Tasks` WHERE `ID` = $taskId;
                        SQL;
                        $result = $db->query($sql);
                        $task = $result->fetch_assoc();
                        //Finally, Populate tasks array (Make object)
                        array_push($tasks, array("id"=>$taskId, "setTaskId"=>$setTaskId, "name"=>$task["TaskSubject"], "description"=>$task["TaskDescription"], "setBy"=>$teacherName, "points"=>$task["TaskPoints"], "dueBy"=>$taskDueDateStr, "overdue"=>$taskOverdue, "fileIdentifier"=>$task["TaskFileIdentifier"]));
                    }

                }   


            }


            //Sort tasks by points
            $points = array_column($tasks, 'points');
            array_multisort($points, SORT_DESC, $tasks);
            //Sort tasks by date due
            $due = array_column($tasks, 'dueBy');
            array_multisort($due, SORT_ASC, $tasks);
            

            return $tasks;
        }


        //Write about duplicate tasks in SetTasks table
        function getSetTaskId($task){
            $sql = <<<SQL
            SELECT `ID` FROM `SetTasks` WHERE `TaskID` = {$task["id"]};
            SQL;


            $db = Utils::connectDatabase();

            $result = $db->query($sql);
            $result = $result->fetch_all();

            if(count($result)<2){
                $result = intval($result);
            }

            return $result;
        }
        
    //---------------------------------




    }
?>