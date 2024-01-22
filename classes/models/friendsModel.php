<?php
    namespace models;
    class friendsModel{
        public static function getFriendsId($id){
            $sql = \Mysql::conectar()->prepare('SELECT * FROM `tb_site.solicitacoes` WHERE (id_to=? AND status = ?) OR (id_from=? AND status = ?)');
            $sql->execute([$id,1,$id,1]);
            $info = $sql->fetchAll();
            $ids = [];
            foreach ($info as $key => $value) {
                if($value['id_to'] == $id){
                    $ids[] = $value['id_from'];
                }else{
                    $ids[] = $value['id_to'];
                }
            }

            return $ids;
        }

        public static function getfriends(){
            $sql = \Mysql::conectar()->prepare(
                'SELECT *
                FROM `tb_site.solicitacoes`
                INNER JOIN `tb_admin.usuarios`
                ON `tb_site.solicitacoes`.id_from = `tb_admin.usuarios`.id OR `tb_site.solicitacoes`.id_to = `tb_admin.usuarios`.id
                WHERE (id_from = ? AND status = ?) OR (id_to=? AND status = ?)
                ');
            $sql->execute([$_SESSION['id'],1,$_SESSION['id'],1]);
            $arr = $sql->fetchAll();
            foreach ($arr as $key => $value) {
                if($value['id'] == $_SESSION['id']){
                    unset($arr[$key]);
                }
            }

            return $arr;
        }

        public static function getNewFriends($id){
            $friends = self::getFriendsId($id);
            $newFriends = [];

            $sql = \Mysql::conectar()->prepare('SELECT * FROM `tb_admin.usuarios`');
            $sql->execute();
            $info = $sql->fetchAll();
            
            foreach ($info as $key => $value) {
                $amigo = false;
                //remover próprio usuário
                if($value['id'] == $_SESSION['id']){
                    continue;
                }
                
                if(count($friends) != 0){
                    foreach ($friends as $key => $value2) {
                        if($value['id'] == $value2){
                            //é amigo
                            $amigo = true;
                        }
                    }
                    if(!$amigo){ 
                        $newFriends[] = $value;
                    }
                }else{
                    $newFriends[] = $value;
                }
            }

            return $newFriends;
            
        }

        public static function getWaiting($id){
            $waiting = \Mysql::conectar()->prepare('SELECT * FROM `tb_site.solicitacoes` WHERE id_from = ? AND status = ?');
            $waiting->execute([$id,0]);
            $waiting = $waiting->fetchAll();
            $ids = [];
            foreach ($waiting as $key => $value) {
                $ids[] = $value['id_to'];
            }
            return $ids;
        }
    }
?>