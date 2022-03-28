<?php
    class CompletedTask {
        function __construct(){
            $this->id = 0;
            $this->userId = 0;
            $this->marksAchieved = 0;
            $this->totalMarks = 0;
            $this->dateCompleted = "";
            $this->setTaskId = 0;
        }

        function setId($id){
            $this->id = $id;
        }

        function setSetTaskId($setTaskId){
            $this->setTaskId = $setTaskId;
        }

        function setUserId($userId){
            $this->userId = $userId;
        }

        function setMarksAchieved($marksAchieved){
            $this->marksAchieved = $marksAchieved;
        }

        function setTotalMarks($totalMarks){
            $this->totalMarks = $totalMarks;
        }
        function setDateCompleted($date){
            $this->dateCompleted = $date;
        }

        function submit(){

            $db = Utils::connectDatabase();

            //CompletedTask ---
            $sql = <<<SQL
                INSERT INTO `CompletedTasks`(`ID`, `SetTaskID`, `StudentID`, `MarksAchieved`, `MarksTotal`, `DateCompleted`) VALUES (NULL, $this->setTaskId, $this->userId, $this->marksAchieved, $this->totalMarks, '$this->dateCompleted');
                SQL;


            $db->query($sql);

        }


        function getId(){
            $sql = <<<SQL
            SELECT `ID` FROM `CompletedTasks` WHERE `SetTaskID` = {$this->setTaskId} AND `StudentID` = {$this->userId};
            SQL;


            $db = Utils::connectDatabase();

            $result = $db->query($sql);

            

            $result = $result->fetch_all()[0][0];

            $result = intval($result);

            return $result;
        }


        static function checkCompleted($setTaskId, $userId){
            $db = Utils::connectDatabase();

            //Query
            $sql = <<<SQL
                SELECT * FROM `completedtasks` WHERE `SetTaskID` = $setTaskId AND `StudentID` = $userId;
                SQL;

            $result = $db->query($sql);

            $result = $result->fetch_all();

            if(count($result)<2){
                $result = intval($result);
            }

            return $result;
        }



    }
?>