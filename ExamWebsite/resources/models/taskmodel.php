<?php
    class Task {

        function getTasks($user){
            //PLACEHOLDER
            //JUST RETURNS HARDCODED TASKS
            $tasks = [];

            //dueBy will be changed to UK standard before storage.
            array_push($tasks,  array("name"=>"Maths", "description"=>"Multiplication and division", "setBy"=>"Mr Glew", "points"=>24, "dueBy"=>"16/03/2022"));
            array_push($tasks,  array("name"=>"English", "description"=>"Metaphors and similes", "setBy"=>"Mr Wills", "points"=>35, "dueBy"=>"20/04/2022"));
            array_push($tasks,  array("name"=>"French", "description"=>"Basic words", "setBy"=>"Mrs Timms", "points"=>14, "dueBy"=>"19/03/2022"));
            array_push($tasks,  array("name"=>"Geography", "description"=>"Map reading", "setBy"=>"Mr Carthew", "points"=>22, "dueBy"=>"30/06/2022"));

            //Sort tasks by points
            $points = array_column($tasks, 'points');
            array_multisort($points, SORT_DESC, $tasks);

            return $tasks;
        }

    }
?>