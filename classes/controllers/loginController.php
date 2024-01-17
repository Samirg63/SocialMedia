<?php
    namespace controllers;

    class loginController{


        public function index(){
            #REGISTRAR
            if(isset($_POST['registrar'])){
                $nome = $_POST['nome'];
                $nascimento = $_POST['nascimento'];
                $genero = $_POST['genero'];
                $user = $_POST['user'];
                $login = $_POST['login'];
                //senha critografada
                $senha = \Bcrypt::hash($_POST['senha']);

                $continue = true;

                if(preg_match('/[a-z]/',$login)){
                    #é email
                    if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
                        $continue = false;
                    }
                }

                if($continue){

                    $sql = \Mysql::conectar()->prepare('INSERT INTO `tb_admin.usuarios` VALUES(null,?,?,?,?,?,?,?,?,?)');
                    $sql->execute([$nome,$nascimento,$genero,$user,$login,$senha,'','','']);
                    $id = \MySql::conectar()->lastInsertId();
                    $img = ''; #ADICIONAR SISTEMA DE IMAGEM
                    \site::login($nome,$id,$img);
                }else{
                    echo '<script>alert("E-mail invalido")</script>';
                }
            }

            if(isset($_POST['logar'])){
                $login = $_POST['login'];
                $senha = $_POST['senha'];
                if($login == '' || $senha == ''){
                    echo '<script>alert("Preencha todos os campos!")</script>';
                }else{

                    $sql = \Mysql::conectar()->prepare('SELECT * FROM `tb_admin.usuarios` WHERE login = ?');
                    $sql->execute([$login]);
                    $info = $sql->fetch();                   
                    
                    if(\Bcrypt::check($senha,$info['senha'])){
                        #SUCESSO
                        \site::login($info['nome'],$info['id'],$info['img']);
                    }else{
                        #ERRO
                        echo '<script>alert("Usuario ou senha incorretos...")</script>';
                    }
                }
            }
            \views\mainview::render('login');
        }
    }
?>