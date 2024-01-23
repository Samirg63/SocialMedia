<?php
    namespace controllers;

    class perfilController{

        public function index($par = null){
            if(isset($_FILES['foto'])){
                $imagem = $_FILES['foto'];
                if(\site::imagemValida($imagem)){
                    $imgName = \site::uploadFile($imagem, 'pre');
                    echo '<preview img="'.$imgName.'"></preview>';
                }
            }

            if(isset($_POST['bio'])){
                $bio = $_POST['bio'];
                $user = $_POST['user'];
                //Validar Usuário
                if($user != $_SESSION['login']){

                    $sql = \Mysql::conectar()->prepare('SELECT * FROM `tb_admin.usuarios` WHERE user = ?');
                    $sql->execute([$user]);
                    if($sql->rowCount() != 0){
                        echo '<script>alert("Nome de usuário ja existe!")</script>';
                    }
                }else{

                    
                    if($_POST['senha'] != ''){
                        $senha = \Bcrypt::hash($_POST['senha']);
                        
                        $sql = \Mysql::conectar()->prepare('UPDATE `tb_admin.usuarios` SET bio=?,user=?,senha=? WHERE id=?');
                        $sql->execute([$bio,$user,$senha,$_SESSION['id']]);
                    }else{
                        $sql = \Mysql::conectar()->prepare('UPDATE `tb_admin.usuarios` SET bio=?,user=? WHERE id=?');
                        $sql->execute([$bio,$user,$_SESSION['id']]);
                    }
                    echo '<script>Perfil editado com sucesso!</script>';
                }
            }

            if(isset($par)){

                if($par[3] != 'amigos' && $par[3] != 'addAmigos'){
                    \views\mainview::pureRender('seeUser',$par);
                }else{
                    \views\mainview::pureRender('perfil');
                }
            }else{
                \views\mainview::pureRender('perfil');
            }
        }
    }
?>