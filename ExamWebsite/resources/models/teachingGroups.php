<?php
    include_once "../libraries/utilities.php";
    class TeachingGroups {

        function __construct($user){
            $this->user = $user;
        }

        function getGroups(){
            $db = Utils::connectDatabase();
            $teachingGroups = [];
            $sql = <<<SQL
                SELECT * FROM `TeachersTeachingGroups` WHERE `TeacherID` = {$this->user->getUserId()};
                SQL;
            $result = $db->query($sql);


            while($row = $result->fetch_assoc()){
                $sqlTeachingGroup = <<<SQL
                    SELECT * FROM `TeachingGroups` WHERE `ID` = {$row["TeachingGroupID"]};
                SQL;
                
                $groupResult = $db->query($sqlTeachingGroup);
                $teachingGroup = $groupResult->fetch_assoc();

                array_push($teachingGroups, $teachingGroup);
            }

            return $teachingGroups;
        }

        function newTeachingGroup($teachingGroupName){
            $db = Utils::connectDatabase();
            $today = Utils::today_dbformatted();
            $sql = <<<SQL
                INSERT INTO `TeachingGroups` VALUES (NULL, '$teachingGroupName','$today')
                SQL;
            //Create teaching group
            $db->query($sql);

            //$db->insert_id is a thing?


            //Assign teacher to teaching group
            $sql = <<<SQL
                INSERT INTO `TeachersTeachingGroups` VALUES ('{$this->user->getUserId()}', '{$db->insert_id}')
            SQL;

            $db->query($sql);
        }


        function removeTeachingGroup($teachingGroupId){
            $db = Utils::connectDatabase();
            $today = Utils::today_dbformatted();
            $sql = <<<SQL
                DROP FROM `TeachingGroups` WHERE `ID` = $teachingGroupId;
                SQL;

            $db->query($sql);
        }


        function getStudents($groupId){
            $db = Utils::connectDatabase();
            $sql = <<<SQL
                SELECT * FROM `TeachingGroupStudents` WHERE `TeachingGroupID` = {$groupId};
            SQL;
            
            $result = $db->query($sql);

            $students = [];

            while($row = $result->fetch_assoc()){
                $sql = <<<SQL
                    SELECT * FROM `Students` WHERE `ID` = {$row["StudentID"]};
                SQL;

                $result = $db->query($sql);
                $student = $result->fetch_assoc();
                array_push($students, $student);
            }

            return $students;

        
        }
    }
?>