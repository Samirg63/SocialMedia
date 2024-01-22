<?php
    namespace models;
    class seeUserModel{
        public static function getUserPosts($id){
            $sql = \Mysql::conectar()->prepare('SELECT * FROM `tb_site.posts` WHERE id_user=?');
            $sql->execute([$id]);

            return $sql->fetchAll();
        }

        public static function getUserFriends($id){
            $sql = \Mysql::conectar()->prepare(
                'SELECT *
                FROM `tb_site.solicitacoes`
                INNER JOIN `tb_admin.usuarios`
                ON `tb_site.solicitacoes`.id_from = `tb_admin.usuarios`.id OR `tb_site.solicitacoes`.id_to = `tb_admin.usuarios`.id
                WHERE (id_from = ? AND status = ?) OR (id_to=? AND status = ?)
                ');
            $sql->execute([$id,1,$id,1]);
            $arr = $sql->fetchAll();
            foreach ($arr as $key => $value) {
                if($value['id'] == $id){
                    unset($arr[$key]);
                }
            }

            return $arr;
        }
    }
?>