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
                $sql = \Mysql::conectar()->prepare('UPDATE `tb_admin.usuarios` SET bio=? WHERE id=?');
                $sql->execute([$bio,$_SESSION['id']]);
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