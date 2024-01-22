<?php
    namespace models;
    class feedModel{
        public static function getPosts(){
            $sql = \Mysql::conectar()->prepare(
                'SELECT *
                FROM `tb_site.solicitacoes`
                INNER JOIN `tb_site.posts`
                ON `tb_site.solicitacoes`.id_from = `tb_site.posts`.id_user OR `tb_site.solicitacoes`.id_to = `tb_site.posts`.id_user
                WHERE (id_from = ? AND status = ?) OR (id_to = ? AND status = ?)
            ');
            $sql->execute([$_SESSION['id'],1,$_SESSION['id'],1]);
            if($sql->rowCount() == 0){
                $sql = \Mysql::conectar()->prepare('SELECT * FROM `tb_site.posts` WHERE id_user = ?');
                $sql->execute([$_SESSION['id']]);
            }
            
            return array_unique($sql->fetchAll());
        }

        public static function getReplyQuantity($id){
            $sql = \Mysql::conectar()->prepare('SELECT * FROM `tb_site.reply.comments` WHERE id_comment = ?');
            $sql->execute([$id]);
            return $sql->rowCount();
        }
    }
?>