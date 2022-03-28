<?php
    include_once "../resources/models/result.php";
    include_once "../resources/models/completedtask.php";
    include_once "../resources/models/taskanswer.php";
    include_once "../resources/models/leaderboard.php";
    include_once "../libraries/utilities.php";

    //Takes POST data
    //Validates
    //Compare answers to JSON
    //Upload results to database (and somehow any open ended questions)
    //Return success
    class TaskSubmitter {


    function __construct($formPostData, $taskReader, $user){
        $this->formData = $formPostData;
        $this->formData = json_decode($this->formData, true);
        $this->taskReader = $taskReader;
        $this->user = $user;
        $this->userAnswers = [];
        $this->userAnswerable = [];
        $this->fileQuestions = [];

        $this->finalResults = [];
    }


    private function checkAnswerable($id){
        if(isset($this->fileQuestions[$id]) 
        && array_key_exists("answer", $this->fileQuestions[$id])){
            //This is answerable
            array_push($this->userAnswerable, $id);
            return count($this->userAnswerable)-1; //return the ID
        }
        //If not return -1;
        return -1;
    }


    function checkAnswers(){
       $this->taskReader->readTaskFile();

        $this->fileQuestions = $this->taskReader->getQuestions();


        $setAnswers = [];

        $this->userAnswerable = [];


        //Increment through each user answer
        //Get the id from the name (q_#)
        //Check if the question in the JSON file has an answer
        //Compare answers

        for($i=0; $i<count($this->formData); $i++){
            $currentFormId = $this->validateInput($this->formData[$i]["name"]);
            $currentFormValue = $this->validateInput($this->formData[$i]["value"]);
            
            array_push($this->userAnswers, $currentFormValue);
            


            $qPos = strpos($currentFormId, "q_")+2;

            //Since qPos can be 0 but not false, is_numeric is used to check.
            if(is_numeric($qPos) && strlen($currentFormId)<4){
                $id = substr($currentFormId, $qPos);
                $id = intval($id);
                //We now have integer id from post.
                //Check the corresponding question in the JSON file
                $this->checkAnswerable($id);
            }
        }


            //Now we have array of user answers
            //Compare answers against JSON ids
            for($i=0; $i<count($this->userAnswerable); $i++){
                $fileAnswer = $this->fileQuestions[$i]["answer"];
                $fileMarks = $this->fileQuestions[$i]["marks"];
                $userAnswer = $this->userAnswers[$this->userAnswerable[$i]];
                $userMarks = 0;
                //Simple usage of ternary operator to build string
                $answerCorrect = ($fileAnswer===$userAnswer);
                $answerCorrectStr = $answerCorrect ? "correct" : "incorrect";

                if($answerCorrect){
                    $userMarks = $fileMarks;
                }
                
                $result = new UserResult();
                $result->questionNo = $this->userAnswerable[$i];
                $result->marksEarned = $fileMarks;
                $result->totalMarks = $fileMarks;
                $result->answer = $userAnswer;

                array_push($this->finalResults, $result);

                
            }

            return $this->finalResults;
    }

    function calculatePoints(){
        //Points = ceil(allMarksEarned * 1.875)

        $allMarksEarned = 0;

        for($i = 0; $i<count($this->finalResults); $i++){
            $result = $this->finalResults[$i];
            $allMarksEarned += $result->marksEarned;
        }

        $points = ceil($allMarksEarned * 1.875);
        return $points;

    }

    function submit($setTaskId){
        //To submit
        //Need to update:
        //CompleteTasks
        //TaskAnswers 

        //CompleteTasks ---
        $totalMarks = 0;
        $marksAchieved = 0;
        
        for($i=0; $i<count($this->finalResults); $i++){
            $result = $this->finalResults[$i];
            $marksAchieved += $result->marksEarned;
            $totalMarks += $result->totalMarks;

        }

        $completedTask = new CompletedTask();

        $completedTask->setSetTaskId($setTaskId);
        $completedTask->setUserId($this->user->getUserId());
        $completedTask->setMarksAchieved($marksAchieved);
        $completedTask->setTotalMarks($totalMarks);
        $completedTask->setDateCompleted(Utils::today_dbformatted());

        $completedTask->submit();

        //TaskAnswers ---
        
        for($i=0; $i<count($this->userAnswers); $i++){
            $result = $this->userAnswers[$i];
            $taskAnswer = new TaskAnswer(); 
            $taskAnswer->setCompletedTaskId($completedTask->getId());   
            $taskAnswer->setQuestionNo($i);
            $taskAnswer->setAnswer($result);
            $answerable = $this->checkAnswerable($i);
            $marksAchieved = 0;

            if($answerable != -1)
                $marksAchieved = $this->finalResults[$this->userAnswerable[$answerable]]->marksEarned;

            $taskAnswer->setMarksAchieved($marksAchieved);
            $taskAnswer->submit();
            
        }

        //Leaderboard
        $leaderboard = new Leaderboard($this->user);
        $points = $this->calculatePoints();
        $leaderboard->addPoints($points);

        return "done";
    }

    //Taken from login script
    function validateInput($input){
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
}



?>