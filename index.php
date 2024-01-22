<?php
    include('config.php');
    $_SESSION['temp_email'] = 'samir-gomes13@hotmail.com';

    $loginController = new controllers\loginController();
    $homeController = new controllers\homeController();
    $erroController = new controllers\erroController();

    $url = isset($_GET['url']) ? $_GET['url'] : 'home';

    if(!isset($_SESSION['login']) && $url != 'login'){
        site::redirect(PATH.'login');
        die();
    }

    Router::get('/login',function() use ($loginController){ 
        $loginController->index();
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
