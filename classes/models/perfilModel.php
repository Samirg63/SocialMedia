<?php
    namespace models;
    class perfilModel{
        public static function getInfoPerfil(){
            $sql = \Mysql::conectar()->prepare('SELECT * FROM `tb_admin.usuarios` WHERE id = ?');
            $sql->execute([$_SESSION['id']]);
            return $sql->fetch();
        }

    }
?>