<?php
    class CompletedTask {
        function __construct(){
            $this->userId = 0;
            $this->marksAchieved = 0;
            $this->totalMarks = 0;
            $this->dateCompleted = "";
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
        function setDateCompleted($today){
            $this->dateCompleted = $today;
        }

        function submit(){
            
        }

    }
?>