<?php

include_once "../libraries/utilities.php";

class Leaderboard {

    function __construct($user){
        $this->user = $user;
    }
    
    function addPoints($points){
        $db = Utils::connectDatabase();
        $userId = $this->user->getUserId();

        $sqlCheckExists = <<<SQL
            SELECT `ID` FROM `Leaderboard` WHERE `StudentID` = $userId
            SQL;
        
        $result = $db->query($sqlCheckExists);

        $row = $result->fetch_assoc();

        if($row){

            $sqlUpdateEntry = <<<SQL
                UPDATE `leaderboard` SET `StudentScore` = `StudentScore` + $points  WHERE `StudentID` = $userId;
            SQL;
            $result = $db->query($sqlUpdateEntry);

        }else{
            $sqlNewEntry = <<<SQL
            INSERT INTO `Leaderboard` VALUES (NULL, $userId, $points)
            SQL;
            $result = $db->query($sqlNewEntry);

        }

    }


    function getLeaderboard(){
        $db = Utils::connectDatabase();
        $sql = <<<SQL
            SELECT * FROM `Leaderboard` WHERE 1
            SQL;
        $result = $db->query($sql);


        $leaderboard = [];

        while($row = $result->fetch_assoc()){
            $studentId = $row["StudentID"];
            $sqlStudentName = <<<SQL
                SELECT `StudentName` FROM `Students` WHERE `ID` = $studentId;
                SQL;
            $studentName = $db->query($sqlStudentName)->fetch_all()[0][0];
            
            $array = array("id"=>$row["ID"], "name"=>$studentName, "points"=>$row["StudentScore"]);
            array_push($leaderboard, $array);
        }

        //Sort leaderboard by points
        $points = array_column($leaderboard, 'points');
        array_multisort($points, SORT_DESC, $leaderboard);

        return $leaderboard;
        
    }

    function getPoints(){
        $db = Utils::connectDatabase();
        $points = 0;
        $userId = $this->user->getUserId();
        $sql = <<<SQL
        SELECT `StudentScore` FROM `Leaderboard` WHERE `StudentID` = $userId;
        SQL;
        $result = $db->query($sql);
        $score = $result->fetch_all();
        if($score){
            $score = $score[0][0];
            return $score;
        }else{
            return 0;
        }
        
    }

}

?>