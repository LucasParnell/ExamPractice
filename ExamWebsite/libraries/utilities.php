<?php
    class Utils {

        static function today(){
            return new DateTime();
        }

        static function today_dbformatted(){
            $today = new DateTime();
            return $today->format("Y-m-d");
        }

        static function connectDatabase(){
            $db = new mysqli("localhost", "GibJohn", "Z4yrJvyG)qaqsFFH", "gibjohn");
            if($db->connect_errno){
                echo "Database Failed";
            }
            return $db;
        }
    }

    
?>