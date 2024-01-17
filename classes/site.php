<?php
    class site{
        public static function redirect($path){
            echo '<script>window.location.href="'.$path.'"</script>';
        }

        public static function login($nome,$id,$img){
            $_SESSION['login'] = $nome;
            $_SESSION['id'] = $id;
            $_SESSION['img'] = $img;

            self::redirect(PATH);
            die();
        }

        public static function imagemValida($imagem){
            if($imagem['type'] == "image/jpeg" ||
                $imagem['type'] == "image/jpg" ||
                $imagem['type'] == "image/png"){

                $tamanho = intval($imagem['size']/1024);
                $maxSize = 10 * 1024 * 1024; //10mb
                if($tamanho <= $maxSize){
                    return true;
                } else{
                    return false;
                }
            } else{
                return false;
            }
        }

        public static function imagensValidas($type,$size){
            if($type == "image/jpeg" ||
            $type == "image/jpg" ||
            $type == "image/png"){

            //Verifica tamanho da imagem
            $maxSize = 10 * 1024 * 1024; //10mb
            if($size <= $maxSize){
                return true;
            }   else{
                return false;
            }
            } else{
                return false;
            }
        }

        public static function uploadFile($file, $destiny = 'full'){
            $formatoArquivo = explode(".",$file['name']);
            $nomeArquivo = uniqid().".".$formatoArquivo[count($formatoArquivo) - 1];

            if($destiny == 'pre'){
                mkdir(BASE_DIR.'/preUploads/'.$_SESSION['id']);
                if(move_uploaded_file($file['tmp_name'],BASE_DIR.'/preUploads/'.$_SESSION['id'].'/'.$nomeArquivo))
                    return $nomeArquivo;
                else
                    return false;
            }else{
                if(move_uploaded_file($file['tmp_name'],BASE_DIR.'/uploads/'.$nomeArquivo))
                    return $nomeArquivo;
                else
                    return false;
            }
        }

        public static function confirmUpload(){
            $arquivo = scandir(BASE_DIR.'/preUploads/'.$_SESSION['id']);
            $arquivo = $arquivo[count($arquivo) - 1];
            rename(BASE_DIR.'/preUploads/'.$_SESSION['id'].'/'.$arquivo , BASE_DIR.'/uploads/'.$arquivo);
            rmdir(BASE_DIR.'/preUploads/'.$_SESSION['id']);
        }

        public static function uploadFiles($name,$tmp_name){
            $formatoArquivo = explode(".",$name);
            $nomeArquivo = uniqid().".".$formatoArquivo[count($formatoArquivo) - 1];

            if(move_uploaded_file($tmp_name,BASE_DIR.'/uploads/'.$nomeArquivo))
                return $nomeArquivo;
            else
                return false;
        }

        public static function deleteFile($file,$destiny = 'full'){
            if($destiny == 'pre'){
                @unlink(BASE_DIR.$_SESSION['id'].'/preUploads/'.$file);
            }else{
                echo BASE_DIR.'/uploads/'.$file;
                @unlink(BASE_DIR.'/uploads/'.$file);
            }

        }

        public static function getUserInfo($id){
            $sql = Mysql::conectar()->prepare('SELECT * FROM `tb_admin.usuarios` WHERE id=?');
            $sql->execute([$id]);
            return $sql->fetch();
        }

        public static function hasLiked($idPost){
            $sql = Mysql::conectar()->prepare('SELECT * FROM `tb_admin.likes` WHERE id_user = ? AND id_post = ?');
            $sql->execute([$_SESSION['id'],$idPost]);
            if($sql->rowCount() == 0){
                return false;
            }else{
                return true;
            }
        }

        public static function getFotos(){
            $sql = Mysql::conectar()->prepare('SELECT images FROM `tb_site.posts` WHERE id_user=?');
            $sql->execute([$_SESSION['id']]);
            return $sql->fetchAll();
        }

        public static function getComments($postId){
            $sql = Mysql::conectar()->prepare('SELECT * FROM `tb_site.comments` WHERE post_id = ?');
            $sql->execute([$postId]);
            return $sql->fetchAll();
        }
    }
?>