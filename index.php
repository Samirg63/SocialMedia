<?php
    include('config.php');

    //Deletar tokens de nova senha;
    site::deleteTokens();

    $loginController = new controllers\loginController();
    $forgotPasswordController = new controllers\forgotPasswordController();
    $homeController = new controllers\homeController();
    $erroController = new controllers\erroController();

    $url = isset($_GET['url']) ? $_GET['url'] : 'home';

    if(!isset($_SESSION['login']) && $url != 'login' && $url != 'esqueci-minha-senha'){
        site::redirect(PATH.'login');
        die();
    }

    Router::get('/login',function() use ($loginController){ 
        $loginController->index();
        die();
    });

    Router::get('/esqueci-minha-senha',function() use ($forgotPasswordController){ 
        $forgotPasswordController->index();
        die();
    });

    Router::get('/',function(){ 
        site::redirect(PATH_HOME);
        die();
    });

    Router::get('/home',function() use ($homeController){ 
        $homeController->index();
        die();
    });
    Router::get('/home/?',function() use ($homeController){ 
        $homeController->index();
        die();
    });
    Router::get('/home/?/?',function() use ($homeController){ 
        $homeController->index();
        die();
    });

    Router::get('/?',function() use ($erroController){ 
        $erroController->index();
        die();
    });


    ?>
