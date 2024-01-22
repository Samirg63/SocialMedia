<?php
    namespace controllers;

    class homeController{

        public function index(){
            if(isset($_GET['logout'])){
                unset($_SESSION['login']);
                unset($_SESSION['id']);
                unset($_SESSION['img']);
                \site::redirect(PATH);
                die();
            }
            if(isset($_POST['conteudo'])){
                $conteudo = $_POST['conteudo'];
                $images = $_FILES['fotos'];
                $imgString = '';
                $first = true;
                
                //UPLOAD ARQUIVOS
                //print_r($images);
                for ($i=0; $i < count($images['type']); $i++) { 
                    $right = \site::imagensValidas($images['type'][$i],$images['size'][$i]);
                    
                    if($right){
                        if($first){
                            $imgString .= \site::uploadFiles($images['name'][$i],$images['tmp_name'][$i]);
                            $first = false;
                        }else{
                            $imgString .= '<-!->';
                            $imgString .= \site::uploadFiles($images['name'][$i],$images['tmp_name'][$i]);
                        }
                    }else{
                        break;
                    }
                }
            
                if(!$right){
                    echo '<script>alert("Imagens inválidas!")</script>';
                }else{
                    //Criar post
                    $sql = \Mysql::conectar()->prepare('INSERT INTO `tb_site.posts` VALUES(null,?,?,?,?,?,?)');
                    $sql->execute([$imgString,$conteudo,date('d/m/Y',time()),0,0,$_SESSION['id']]);
                    \site::redirect(PATH_HOME);
                    die();
                }
            }
            \views\mainview::render('home');
        }
    }
?>