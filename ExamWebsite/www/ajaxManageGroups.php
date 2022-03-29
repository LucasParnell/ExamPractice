<?php
include_once "../libraries/boilerplate.php";
include_once "../resources/models/user.php";
include_once "../resources/models/teachingGroups.php";
session_start();
if(isset($_SESSION)){
    $user = unserialize($_SESSION["User"]);
    if($user->getUserType()=="teacher"){
        if(isset($_POST["newGroup"])){
            $newGroupName = $_POST["newGroup"];
            $teachingGroups = new TeachingGroups($user);
            $teachingGroups->newTeachingGroup($newGroupName);
            echo "a";
        }
        elseif(isset($_POST["removeGroup"])){
            $groupId = $_POST["removeGroup"];
            $teachingGroups = new TeachingGroups($user);
            $teachingGroups->removeTeachingGroup($groupId);
        }

}
}

?>