<?php
    namespace models;
    class homeModel{
        public static function checkNewNotification(){
            $sql = \Mysql::conectar()->prepare('SELECT * FROM `tb_site.notificacoes` WHERE id_to = ? AND view = ?');
            $sql->execute([$_SESSION['id'],0]);
            if($sql->rowCount() > 0){
                return $sql->rowCount();
            }else{
                return false;
            }
        }

        public static function getNotifications(){
            $sql = \Mysql::conectar()->prepare('SELECT * FROM `tb_site.notificacoes` WHERE id_to = ?');
            $sql->execute([$_SESSION['id']]);
            return $sql->fetchAll();
        }

        public static function getPostInfo($id){
            $sql = \Mysql::conectar()->prepare('SELECT * FROM `tb_site.posts` WHERE id = ?');
            $sql->execute([$id]);

            return $sql->fetch();
        }
        public static function getCommentInfo($id){
            $sql = \Mysql::conectar()->prepare('SELECT * FROM `tb_site.comments` WHERE id = ?');
            $sql->execute([$id]);

            return $sql->fetch();
        }
    }
?>