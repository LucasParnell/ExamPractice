
<?php
    session_start();
    include_once "../libraries/boilerplate.php";
    include_once "../resources/controllers/logincontroller.php";
 
    $status = [];

    $isSigning = "0";

    $emailAutoFill = "";
    $nameAutoFill = "";
    $dateAutoFill = "";

    if(sizeof($_POST)>0){
        //There is POST data, make sure it is the right data
        $login = new Login($_POST);

        $status = $login->process();

        if(!in_array("signedUp", $status) && !in_array("loggedIn", $status)){
            session_abort();
        }else{
            $login->toSession();
        }


        if(in_array("signedUp",$status)){
            header("Location: signedup.php");
        }
        else if(in_array("loggedIn", $status)){
            header("Location: loggedin.php");
        }

        //Autofill
        if(array_key_exists("email", $_POST)){
            $emailAutoFill = $_POST["email"];
        }

        if(array_key_exists("name", $_POST)){
            $nameAutoFill = $_POST["fullName"];
        }
        if(array_key_exists("dateOfBirth", $_POST)){
            $dateAutoFill = $_POST["dateOfBirth"];
        }

    }

    if(array_key_exists("sign", $_GET) && $_GET["sign"]==1 || array_key_exists("isSigning", $_POST)){
        $isSigning = "1";

    }

    echo $blade->run("login", array("status" => $status, "isSigning"=>$isSigning, "emailAutoFill"=>$emailAutoFill, "nameAutoFill"=>$nameAutoFill, "dateAutoFill"=>$dateAutoFill));





?>
