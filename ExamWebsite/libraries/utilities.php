<?php
    class Utils {

        static function today(){
            return new DateTime();
        }

        static function today_dbformatted(){
            $today = new DateTime();
            return $today->format("Y-m-d");
        }
    }
?>