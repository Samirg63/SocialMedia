<?php
    namespace models;
    class forgotPasswordModel{
        public static function validateToken($token,$email){
            $sql = \Mysql::conectar()->prepare('SELECT * FROM `tb_admin.requestNewPassword` where token=? and email=?');
            $sql->execute([$token,$email]);
            if($sql->rowCount() == 1)
                return true;
            else
                return false;
        }

        
    }
?>