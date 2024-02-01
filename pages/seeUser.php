<?php
    //checar se o perfil existe
    addComponents($arr2['component']);
    addCss($arr2['css']);
    $user = $arr2[0][3];

    $sql = Mysql::conectar()->prepare('SELECT * FROM `tb_admin.usuarios` WHERE user = ?');
    $sql->execute([$user]);
    if($sql->rowCount() == 0){
        echo '<h2 style="margin-left:2.5rem;">Usuário não existe!</h2>';
        die();
    }
    $infoPerfil = $sql->fetch();
    if($infoPerfil['id'] == $_SESSION['id']){
        site::redirect(PATH_HOME.'perfil');
        die();
    }
?>
<section class="user container">
    <div class="userInfo flex">

        <div class="imgPerfil flex" style="pointer-events:none;">
        
        <?php if($infoPerfil['img'] != ''){?>
            <img src="<?=PATH.'uploads/'.$infoPerfil['img'];?>">
        <?php }else{ ?>
            <img src="<?=PATH.'assets/avatar-placeholder.jpg'?>">
        <?php } ?>
        
        </div>

        <div class="info flex">
            <div class="group">
                <h2><?=ucfirst($infoPerfil['user']);?></h2>
                <div class="bio">
                    <?=$infoPerfil['bio']?>
                </div>
            </div>
        </div>
    </div>
    <?php
    //ativar carrosel com 6 imagens
     $fotosStr = site::getFotos($infoPerfil['id']);
     $fotos = [];
     foreach ($fotosStr as $key => $value) {
         $fotoStrSingle = explode('<-!->',$value['images']);
         foreach ($fotoStrSingle as $key => $value2) {
             $fotos[] = $value2;
         }
     }
    ?>
    <div class="userPhotos flex <?php if(count($fotos) >= 6){echo 'carroselPerfil';}?>">
        <?php
         foreach ($fotos as $key => $img) {
            
        ?>
        <div class="photoSingle">
            <img src="<?=PATH.'uploads/'.$img?>">
        </div>
        <?php } ?>
        
    </div>
</section>

<section class="userInfo container">
    <h2>Últimas publicações</h2>

    <div class="flex">
        <div class="ultimosPosts">

        <?php
            $posts = models\seeUserModel::getUserPosts($infoPerfil['id']);
            $userInfo = site::getUserInfo($infoPerfil['id']);
            foreach ($posts as $key => $value) {
                
        ?>
            <div class="postSingle">
                <button class="openOptions"><i class="fa-solid fa-ellipsis"></i></button>
                <div class="options">
                    <ul>
                        <li><button class="deletePost"><i class="fa-regular fa-trash-can"></i><span>Apagar post</span></button></li>
                    </ul>
                </div>
            <div class="user flex">
                <div class="img">
                    <?php if($userInfo['img'] != ''){?>
                        <img src="<?=PATH.'uploads/'.$userInfo['img']?>">
                    <?php }else{ ?>
                        <img src="<?=PATH.'assets/avatar-placeholder.jpg'?>">
                    <?php } ?>
                </div>
                <div class="userInfo">
                    <p><a href="<?=PATH_HOME?>perfil/<?=$userInfo['user']?>"><?=$userInfo['user']?></a></p>
                    <span><?=$value['data']?></span>
                </div>
            </div>

            <div class="info">
                <p><?=$value['content'] ?></p>
                <?php
                $images = explode('<-!->',$value['images']);
                if(count($images) != 0){
                ?>

                <div class="images flex <?php if(count($images) >= 3){echo 'carrosel';}?>">
                    <?php foreach ($images as $key => $valueImg) {
                        ?>

                    <div class="image">
                        <img src="<?=PATH.'uploads/'.$valueImg?>">
                    </div>

                    <?php } ?>
                </div>

                <?php } ?>
            </div>

            <div class="actionBtn flex" idPost="<?=$value['id']?>">
                <button class="like" noFormatedNumber="<?=$value['likes']?> title="<?=site::formatNumberTitle($value['likes'])?>"><i style="<?php if(site::hasLiked($value['id'])){echo 'color:#ff8787;';}?>" class="<?php if(site::hasLiked($value['id'])){echo 'fa-solid';}else{echo 'fa-regular';}?> fa-heart"></i><span><?=site::formatNumber($value['likes'])?></span></button>
                <button class="comment" noFormatedNumber="<?=$value['comments']?> title="<?=site::formatNumberTitle($value['comments'])?>"><i class="fa-regular fa-comment"></i><span><?=site::formatNumber($value['comments'])?></span></button>
            </div>

            <div class="comments closed">
                <h3>Faça seu comentário:</h3>
                <form method="post" class="flex commentForm">
                    <textarea name="comentario" placeholder="Seu comentário..."></textarea>
                    <input type="submit" name="postComment" id="submitComment" style="display:none;">
                    <input type="hidden" name="postId" value="<?=$value['id']?>">
                    <label for="submitComment"><i class="fa-solid fa-paper-plane"></i></label>
                </form>

                <div class="commentsContainer">
                   

                <?php
                    $comments = site::getComments($value['id']);
                    foreach ($comments as $key => $value) {
                    $userInfoComment = site::getUserInfo($value['user_id']);
                ?>
                    <div class="commentSingle">
                        <div class="flex">

                            <div class="commentImg">
                                <?php if($userInfoComment['img'] != ''){?>
                                    <img src="<?=PATH.'uploads/'.$userInfoComment['img']?>">
                            <?php }else{ ?>
                                <img src="<?=PATH.'assets/avatar-placeholder.jpg'?>">
                            <?php } ?>
                            </div>
                            <div class="commentInfo">
                                <p><a href="<?=PATH_HOME?>perfil/<?=$userInfoComment['user']?>"><?=$userInfoComment['user']?></a></p>
                                <span><?=$value['content']?></span>
                            </div>
                        </div><!-- flex -->

                        <div class="actionBtn flex commentActions" idComment="<?=$value['id']?>">
                            <button class="like-comment" "><i  class="fa-regular fa-heart"></i><span>0</span></button>
                            <button class="reply"><i class="fa-solid fa-reply"></i></button>
                            <button class="show"><span class="status">Mostrar</span> Resposta (<span class="quantity"><?= models\feedModel::getReplyQuantity($value['id']) ?></span>)</button>
                        </div><!--actionBtn-->        
                    </div><!--comentSingle-->
                <?php } ?>
                </div>
            </div>
        </div><!--Post-single-->

            <?php } ?>

        </div>

        <?php
        $friends = models\seeUserModel::getUserFriends($infoPerfil['id']);
        if(count($friends) != 0){
        ?>
        <section class="myFriends">
        <p>Amigos</p>
        <div class="amigos">
        <?php
            
            foreach ($friends as $key => $value) {
                
        ?>
            <div class="amigoSingle flex">
                <div class="amigoImg">
                    <?php if($value['img'] != ''){ ?>
                        <img src="<?=PATH.'uploads/'.$value['img']?>">
                    <?php }else{ ?>
                        <img src="<?=PATH.'assets/avatar-placeholder.jpg'?>"> 
                    <?php } ?>
                </div>
                <div class="amigoInfo">
                    <p><a href="<?=PATH_HOME.'perfil/'.$value['user']?>"><?=$value['user']?></a></p>
                    <span>cidade</span>
                </div>
            </div><!--amigoSingle-->
        <?php } ?>
        
            <a href="<?=PATH_HOME?>perfil/amigos">Ver Mais</a>
        </div>
    </section>
    <?php } ?>
    </div>
</section>