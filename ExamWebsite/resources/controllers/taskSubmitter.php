<?php
    include_once "../resources/models/result.php";
    include_once "../resources/models/completedtask.php";
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

        $this->finalResults = [];
    }


    function checkAnswers(){
       $this->taskReader->readTaskFile();

        $fileQuestions = $this->taskReader->getQuestions();


        $setAnswers = [];
        $userAnswers = [];
        $userAnswerable = [];


        //Increment through each user answer
        //Get the id from the name (q_#)
        //Check if the question in the JSON file has an answer
        //Compare answers

        for($i=0; $i<count($this->formData); $i++){
            $currentFormId = $this->validateInput($this->formData[$i]["name"]);
            $currentFormValue = $this->validateInput($this->formData[$i]["value"]);
            
            array_push($userAnswers, $currentFormValue);
            


            $qPos = strpos($currentFormId, "q_")+2;

            //Since qPos can be 0 but not false, is_numeric is used to check.
            if(is_numeric($qPos) && strlen($currentFormId)<4){
                $id = substr($currentFormId, $qPos);
                $id = intval($id);
                //We now have integer id from post.
                //Check the corresponding question in the JSON file
                if(isset($fileQuestions[$id]) 
                    && array_key_exists("answer", $fileQuestions[$id])){
                        //This is answerable
                        array_push($userAnswerable, $id);
                    }
            }
        }


            //Now we have array of user answers
            //Compare answers against JSON ids
            for($i=0; $i<count($userAnswerable); $i++){
                $fileAnswer = $fileQuestions[$i]["answer"];
                $fileMarks = $fileQuestions[$i]["marks"];
                $userAnswer = $userAnswers[$userAnswerable[$i]];
                $userMarks = 0;
                //Simple usage of ternary operator to build string
                $answerCorrect = ($fileAnswer===$userAnswer);
                $answerCorrectStr = $answerCorrect ? "correct" : "incorrect";

                print($fileAnswer . " = " . $userAnswer . " : " . $answerCorrectStr . "<br>");

                if($answerCorrect){
                    $userMarks = $fileMarks;
                }
                
                $result = new UserResult();
                $result->questionNo = $userAnswerable[$i];
                $result->marksEarned = $fileMarks;
                $result->totalMarks = $fileMarks;
                $result->answer = $userAnswer;

                array_push($this->finalResults, $result);

                
            }

            return $this->finalResults;
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

        $completedTask->setUserId($this->user->id);
        $completedTask->setMarksAchieved($marksAchieved);
        $completedTask->setTotalMarks($totalMarks);
        $completedTask->setDateCompleted(Utils::today_dbformatted());

        $completedTask->submit();
    }

    //Taken from login
    function validateInput($input){
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
}



?>