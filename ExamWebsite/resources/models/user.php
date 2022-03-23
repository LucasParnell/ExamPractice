<?php

class User {

    function __construct(){
        $this->fullName = "";
        $this->dateOfBirth = "0-0-0000";
        $this->email = "";
        $this->passwordHash = "";
        $this->isTeacher = false;
        $this->id = 0;
    }

    function setFullName($fullName){
        $this->fullName = $fullName;
    }

    function setDateOfBirth($dateOfBirth){
        $this->dateOfBirth = $dateOfBirth;
    }

    function setEmail($email){
        $this->email = $email;
    }

    function hashAndSetPassword($password){
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }

    function setTeacher($isTeacher){
        $this->isTeacher = $isTeacher;
    }

    function getFirstName(){
        return explode(" ", $this->fullName, 2)[0];
    }

    function getLastName(){
        return explode(" ", $this->fullName, 2)[1];
    }


    function signUp(){
        //Connect DB
        $db = $this->connectDatabase();

        //Check if teacher or not
        if($this->isTeacher){

            //Escape strings to be safe
            $this->fullName = $db->real_escape_string($this->fullName);
            $this->email = $db->real_escape_string($this->email);

            //Current date
            $currentDate = new DateTime();
            $currentDate = $currentDate->format("Y-m-d");
            
            //SQL to try and insert the user data
            $sql = <<<SQL
            INSERT INTO teachers
            (ID, TeacherName, TeacherDateOfBirth, TeacherEmail, TeacherPasswordHash, DateCreated) 
            VALUES 
            (NULL, '$this->fullName', $this->dateOfBirth, '$this->email', '$this->passwordHash', $currentDate)
            SQL;

            //Check if user exists
            if($this->getUserType($db)!="none"){
                return "userExists";
            }
            
            $db->query($sql);

            $id = $this->getUserId();

            //Clear hash as this is serialised.
            $this->passwordHash = "";

            return "signedUp";


        }
        else{
            //Student


            //Escape strings to be safe
            $this->fullName = $db->real_escape_string($this->fullName);
            $this->email = $db->real_escape_string($this->email);

            //Current date
            $currentDate = new DateTime();
            $currentDate = $currentDate->format("Y-m-d");
            
            //SQL to try and insert the user data
            $sql = <<<SQL
                INSERT INTO students
                (ID, StudentName, StudentDateOfBirth, StudentEmail, StudentPasswordHash, DateCreated) 
                VALUES 
                (NULL, '$this->fullName', '$this->dateOfBirth', '$this->email', '$this->passwordHash', '$currentDate')
                SQL;


                $userType = $this->getUserType($db);

                if($userType!="none"){
                    return "userExists";
                }
            
                $db->query($sql);

            //Clear hash as this is serialised.
            $this->passwordHash = "";

            return "signedUp";
        }
    }



    function login($password){
        $db = $this->connectDatabase();
        
        $this->email = $db->real_escape_string($this->email);

        //Figure out if the user is a student or teacher
        $userType = $this->getUserType($db);

        if($userType=="none"){
            return "noUser";
        }
        elseif($userType=="student"){
            $sql = <<<SQL
                SELECT * FROM students WHERE StudentEmail = "$this->email"
                SQL;
            
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            $dbHash = $row["StudentPasswordHash"];

            //Compare passwords
            $passMatch = password_verify($password, $dbHash);

            if($passMatch){
                //Set user details from row
                $this->setFullName($row["StudentName"]);
                $this->setDateOfBirth($row["StudentDateOfBirth"]);
                $this->setTeacher(false);
                return "loggedIn";

            }else{
                return "passIncorrect";
            }

        }
        elseif($userType=="teacher"){
            $sql = <<<SQL
                SELECT * FROM teachers WHERE TeacherEmail = "$this->email"
                SQL;
            
            $result = $db->query($sql);
            $row = $result->fetch_assoc();
            $dbHash = $row["TeacherPasswordHash"];

            //Compare passwords
            $passMatch = password_verify($password, $dbHash);
            if($passMatch){
                //Set user details from row
                $this->setFullName($row["TeacherName"]);
                $this->setDateOfBirth($row["TeacherDateOfBirth"]);
                $this->setTeacher(true);
                $this->id = $this->getUserId();
                return "loggedIn";

            }else{
                return "passIncorrect";
            }            
        }

    }



    function getUserType($db){
        //Check if the user is a student or teacher
        //or if the user doesnt exist at all

        $userType = "none";

        $studentSql = <<<SQL
            SELECT * FROM students WHERE StudentEmail = "$this->email"
            SQL;
        
        $teacherSql = <<<SQL
            SELECT * FROM teachers WHERE TeacherEmail = "$this->email"
            SQL;

        //Student first
        $result = $db->query($studentSql);
        $result = $result->fetch_assoc();
        $userType = "student";

        if(!$result){
            //User is not student, Try teacher
            $result = $db->query($teacherSql);
            $result = $result->fetch_assoc();
            $userType = "teacher";
            //User is not teacher. User doesn't exist
            if(!$result){
                $userType="none";
            }
        }
        
        return $userType;

    }

    function getUserId(){

        $db = $this->connectDatabase();
        $email = $this->email;

        $id = 0;
        $sql = "";
        $userType = $this->getUserType($db);

        if($userType == "teacher"){
            $sql = <<<SQL
            SELECT ID FROM teachers WHERE TeacherEmail = "$this->email"
            SQL;
        }else if ($userType == "student"){
        $sql = <<<SQL
            SELECT ID FROM students WHERE StudentEmail = "$this->email"
            SQL;
        }
        else{
            return -1;
        }

        $result = $db->query($sql);
        $id = $result->fetch_assoc()["ID"];
        return $id;

    }



    //---------------------------------



    function connectDatabase(){
        $db = new mysqli("localhost", "GibJohn", "Z4yrJvyG)qaqsFFH", "gibjohn");
        if($db->connect_errno){
            echo "Database Failed";
        }
        return $db;
    }

}


?>