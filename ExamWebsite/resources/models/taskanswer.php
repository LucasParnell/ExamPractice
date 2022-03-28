<?php
class TaskAnswer {

    function __construct(){
        //CompletedTaskID	QuestionNo	Answer	
        $this->completedTaskId = 0;
        $this->questionNo = 0;
        $this->answer = "";
        $this->marksAchieved = 0;
    }

    function setCompletedTaskId($completedTaskId){
        $this->completedTaskId = $completedTaskId;
    }

    function setQuestionNo($questionNo){
        $this->questionNo = $questionNo;
    }

    function setAnswer($answer){
        $this->answer = $answer;
    }

    
    function setMarksAchieved($marksAchieved){
        $this->marksAchieved = $marksAchieved;
    }

    function submit(){
            
        $db = Utils::connectDatabase();

        //TaskAnswer ---
        $sql = <<<SQL
            INSERT INTO `TaskAnswers` VALUES (NULL, $this->completedTaskId, $this->questionNo, '$this->answer', $this->marksAchieved);
            SQL;

        $db->query($sql);

    }

}
?>