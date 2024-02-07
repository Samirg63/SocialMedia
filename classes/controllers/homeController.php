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

            if(isset($_POST['acao']) && $_POST['acao'] == 'seePreview'){
                $images = $_FILES['fotos'];
                $allImages = [];
                for ($i=0; $i < count($images['type']); $i++) { 
                    $right = \site::imagensValidas($images['type'][$i],$images['size'][$i]);
                    
                    if($right){                      
                            $allImages[] = \site::uploadFiles($images['name'][$i],$images['tmp_name'][$i],'pre');
                    }else
                        break;
                }
                if(!$right){
                    echo '<script>alert("Imagens inválidas!")</script>';
                }else{
                   $_SESSION['previewImgs'] = $allImages;
                }
                
            }

            if(isset($_POST['acao']) && $_POST['acao'] == 'postPhoto'){
                $conteudo = $_POST['conteudo'];
                $images = $_SESSION['previewImgs'];
                $imgString = '';
                $first = true;
                
                //make img string
                foreach ($_SESSION['previewImgs'] as $key => $value) {
                    if($first){
                        $imgString .= $value;
                        $first = false;
                    }else{
                        $imgString .= '<-!->';
                        $imgString .= $value;
                    }
                }
                
            
                
                    //Criar post
                    $sql = \Mysql::conectar()->prepare('INSERT INTO `tb_site.posts` VALUES(null,?,?,?,?,?,?)');
                    if($sql->execute([$imgString,$conteudo,date('d/m/Y',time()),0,0,$_SESSION['id']])){
                        \site::confirmUpload();
                    }
                    
                    \site::redirect(PATH_HOME);
                    die();
                
            }

            if(isset($_POST['acao']) && $_POST['acao'] == 'postNoPhoto'){
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

            if(isset($_GET['editPost'])){
                \views\mainView::pureRender('postEditor', ['component'=>['formulario']] ,'component');
            }
            if(isset($_GET['editComment']) || isset($_GET['editReply'])){
                \views\mainView::pureRender('commentEditor', ['component'=>['formulario']] ,'component');
            }


            \views\mainview::render('home',['css'=>['home']]);
        }
    }
?>