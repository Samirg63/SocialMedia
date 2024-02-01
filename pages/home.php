<?php site::checkLogin();?>
<section class="main flex">
    <aside class="mainAside">
     <div class="full">

      
        <h1>Social.Media</h1>
        <div class="menu">
            <ul>
                <li><a href="<?=PATH_HOME?>?logout"><i class="fa-solid fa-power-off"></i>Sair</a></li>
            </ul>
            <p>Menu</p>
            <ul>
                <li <?php selecionadoMenu('')?>><a href="<?=PATH_HOME?>"><i class="fa-solid fa-newspaper"></i>Feed</a></li>
                <li <?php selecionadoMenu('perfil')?>><a href="<?=PATH_HOME?>perfil"><i class="fa-solid fa-user"></i>Perfil</a></li>
                <li <?php selecionadoMenu('amigos')?>><a href="<?=PATH_HOME?>perfil/amigos"><i class="fa-solid fa-user-group"></i>Amigos</a></li>
                <li <?php selecionadoMenu('addAmigos')?>><a href="<?=PATH_HOME?>perfil/addAmigos"><i class="fa-solid fa-magnifying-glass"></i></i>Faça amigos</a></li>
                <li><a class="openPost" href="#"><i class="fa-regular fa-square-plus"></i>Novo Post</a></li>
                <li>
                    <a class="openNotification" href="#">
                       <div class="group">
                        <i class="fa-solid fa-message"></i>
                        <?php if(models\homeModel::checkNewNotification()){ ?> <div class="badge"></div><?php } ?> 
                        </div>
                        Notificações
                    </a>
                </li>
            </ul>
        </div>
    </div>  
    <div class="resumido" style="display:none;">
        <div class="menu">
            <ul>
                <li><a href="<?=PATH_HOME?>?logout"><i class="fa-solid fa-power-off"></i></a></li>
            </ul>
            <ul>
                <li ><a href="<?=PATH_HOME?>"><i class="fa-solid fa-newspaper"></i></a></li>
                <li ><a href="<?=PATH_HOME?>perfil"><i class="fa-regular fa-user"></i></a></li>
                <li ><a href="<?=PATH_HOME?>perfil/amigos"><i class="fa-solid fa-user-group"></i></a></li>
                <li ><a href="<?=PATH_HOME?>perfil/addAmigos"><i class="fa-solid fa-magnifying-glass"></i></i></a></li>
                <li><a class="openPost" href="#"><i class="fa-regular fa-square-plus"></i></a></li>
                <li><a class="closeNotification" href="#"><i class="fa-solid fa-message"></i></a></li>
            </ul>
        </div>
    </div>

    </aside>
    <aside class="notifications">
        <h2>Notificações</h2>
        <?php
            $notificacoes = models\homeModel::getNotifications();
            if(count($notificacoes) != 0){
            foreach ($notificacoes as $key => $value) {
            $info = site::getUserInfo($value['id_from']);
        ?>
        <div class="notificacaoSingle flex">
            <div class="img">
                <?php if($info['img'] != ''){?>
                    <img src="<?=PATH.'uploads/'.$info['img']?>">
                <?php }else{ ?>
                    <img src="<?=PATH.'assets/avatar-placeholder.jpg'?>">
                <?php } ?>
            </div>
            <div class="group">
                <p><?= $info['user']?></p>
                <span><?=returnMessage($value['action']);?></span>
                <?php if($value['action'] == 'amizade'){?>
                    <div class="actionBtn" id_from="<?= $value['id_from']?>">
                        <button class="accept"><i class="fa-solid fa-check"></i></button>
                        <button class="cancel"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                <?php } ?>
            </div>
        </div><!--Notificação Single-->
        <?php }} ?>
    </aside>
    <div class="content">
        <?php
            $feedController = new controllers\feedController();
            $perfilController = new controllers\perfilController();
            $seeUserController = new controllers\seeUserController();

            Router::get('/home/perfil',function() use ($perfilController){
                $perfilController->index();
            });
            Router::get('/home/perfil/?',function($par) use ($perfilController){               
                    $perfilController->index($par);               
            });
            
            Router::get('/home',function() use ($feedController){ 
                $feedController->index();
            });
            
        ?>
    </div>
</section>
<script src="<?=PATH?>js/jquery.color.js"></script>
<script src="<?=PATH?>js/script.js"></script>