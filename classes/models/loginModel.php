<?php
    namespace models;
    class loginModel{
        public static function generateCode(){
            $code = rand(1,999999);
            if(strlen($code) < 6){
                $implement = 6 - strlen($code);
                for ($i=0; $i < $implement; $i++) { 
                   $code = '0'.$code;
                }
            }
            return $code;
        }
    }
?>