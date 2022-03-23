<?php

    include_once "../resources/models/user.php";

    class Login {


        function __construct($post) {

            $this->postData = $post;
            $this->email = "";
            $this->emailValid = false;

            $pass = true;
            if(array_key_exists("email",$post) && array_key_exists("password", $post)){
                //Can log in
                //validate email
                $validated = $this->validateInput($post["email"]);
                if (filter_var($validated, FILTER_VALIDATE_EMAIL)) { //Php function, filters a variable using enum.
                    $this->emailValid = true;
                    $this->email = $validated;
                  }
            }
        }

        function process(){

            $status = [];

            if(!$this->emailValid){
                array_push($status, "invalidEmail");
                return $status;
            }



            //First, create a new user
            $this->user = new User();

            //Next, check whether the user is trying to log in or sign up
            $signUp = false;
            if(array_key_exists("isSigning", $this->postData)){
                $signUp = true;
            }

                        

            if($signUp){
                $status = array_merge($status, $this->signUp());
                return $status;
            }else{
                $status = array_merge($status, $this->login());
                return $status;
            }

        }

        function signUp(){

            //Status starts empty, error messages are appended
            $status = [];

            $user = $this->user;
            //To sign up, validate inputs for full name and age
            $validName = $this->validateInput($this->postData["fullName"]);

            //Make sure the full name contains spaces
            if(!str_contains($validName, " ")){
                array_push($status, "invalidName");
            }

            $dateOfBirth = new DateTime($this->validateInput($this->postData["dateOfBirth"]));
            $today = new DateTime();
            $difference = $today->diff($dateOfBirth);
            $age = $difference->y;
            

            if($age > 120 || $age < 4){
                array_push($status, "invalidAge");
            }

            //Password length
            if(strlen($this->postData["password"]) < 6 || strlen($this->postData["password"]) > 32){
                array_push($status, "invalidPassword");
            }

            if(count($status)>0){
                //Return with errors
                return $status;
            }

            //Check if the user is a student or a teacher
            $isTeacher = array_key_exists("isTeacher", $this->postData);

            //Populate the user model
            $user->setFullName($validName);
            $user->setDateOfBirth($dateOfBirth->format("Y-m-d"));
            $user->setEmail($this->email);

            //Password is taken from postData to minimise storage of the unhashed value.
            $user->hashAndSetPassword($this->postData["password"]);
            $user->setTeacher($isTeacher);

            //Sign Up
            array_push($status, $user->signUp());
            return $status;
        }

        function login(){
                //Status starts empty, error messages are appended
                $status = [];
                $user = $this->user;


                //The User is Logging in
                $user->setEmail($this->email);
                array_push($status, $user->login($this->postData["password"]));
                return $status;
        }



        function toSession(){
            //To be run after session created
            $_SESSION["User"] = serialize($this->user);
        }

        //Help from W3Schools (https://www.w3schools.com/php/php_form_url_email.asp)
        function validateInput($input){
            $input = trim($input);
            $input = stripslashes($input);
            $input = htmlspecialchars($input);
            return $input;
        }
    }

?>