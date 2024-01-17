<?php
    namespace models;
    class homeModel{
        public static function checkNewNotification(){
            $sql = \Mysql::conectar()->prepare('SELECT * FROM `tb_site.notificacoes` WHERE id_to = ? AND view = ?');
            $sql->execute([$_SESSION['id'],0]);
            if($sql->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        public static function getNotifications(){
            $sql = \Mysql::conectar()->prepare('SELECT * FROM `tb_site.notificacoes` WHERE id_to = ?');
            $sql->execute([$_SESSION['id']]);
            return $sql->fetchAll();
        }
    }
?>