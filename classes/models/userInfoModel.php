<?php
    namespace models;
    class userInfoModel{
        public static function getMyPosts(){
            $sql = \Mysql::conectar()->prepare('SELECT * FROM `tb_site.posts` WHERE id_user=?');
            $sql->execute([$_SESSION['id']]);

            return $sql->fetchAll();
        }
    }
?>