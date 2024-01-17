<?php
    session_start();
    date_default_timezone_set("America/Sao_Paulo");
    #DATABASE
    define('USER','root');
    define('HOST','localhost');
    define('PASSWORD','');
    define('DATABASE','socialMedia2');

    #CONSTS
    define('PATH','http://localhost/SocialMedia_2/');
    define('PATH_HOME','http://localhost/SocialMedia_2/home/');
    define('BASE_DIR',__DIR__);

    #AUTOLOAD
    $autoload = function($class){
        include('classes/'.$class.'.php');
    };

    spl_autoload_register($autoload);

    function selecionadoMenu($par){
        $url = explode("/",@$_GET['url']);
        
    
    
        if($url[count($url) - 1] == $par){
            echo 'class="selected"';
        }
    
    }

    #MENSAGENS DE NOTIFICAÇÃO
    function returnMessage($action){
        if($action == 'amizade'){
            return 'Quer se tornar seu amigo(a).';
        }else if($action == 'amizadeAceita'){
            return 'Se tornou seu amigo(a).';
        }
    }
?>