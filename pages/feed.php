<?php
    $posts = models\feedModel::getPosts();
    addCss($arr2['css']);
    addComponents($arr2['component']);
?>
<div class="flex container">

    <section class="posts">
    <?php
    if(count($posts) == 0){
        echo '<h2 style="color:#454545;opacity:44%;">Faça amigos para ver seus posts...</h2>';
    }else{
        foreach ($posts as $key => $value) {
        $userInfo = site::getUserInfo($value['id_user']);
    ?>
        <div class="postSingle">
            <?php if($_SESSION['id'] == $value['id_user']){?>
                <!-- Habilitar menu caso o post seja seu -->
                <button class="openOptions"><i class="fa-solid fa-ellipsis"></i></button>
                <div class="options">
                    <ul>
                        <li><button class="deletePost"><i class="fa-regular fa-trash-can"></i><span>Apagar post</span></button></li>
                        <li><button class="editPost"><a href="<?=PATH?>?editPost=<?=$value['id']?>">
                            <i class="fa-solid fa-pen"></i><span>Editar post</span></button></li>
                        </a>
                    </ul>
                </div>
            <?php } ?>
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

            <div class="actionBtn flex" idPost="<?=$value['id']?>" ownerId="<?=$userInfo['id']?>">
                <button class="like" noFormatedNumber="<?=$value['likes']?>" title="<?=site::formatNumberTitle($value['likes'])?>"><i style="<?php if(site::hasLiked($value['id'])){echo 'color:#ff8787;';}?>" class="<?php if(site::hasLiked($value['id'])){echo 'fa-solid';}else{echo 'fa-regular';}?> fa-heart"></i><span><?=site::formatNumber($value['likes'])?></span></button>
                <button class="comment" noFormatedNumber="<?=$value['comments']?> title="<?=site::formatNumberTitle($value['comments'])?>"><i class="fa-regular fa-comment"></i><span><?=site::formatNumber($value['comments'])?></span></button>
            </div>

            <div class="comments closed">
                <h3>Faça seu comentário:</h3>
                <form method="post" class="flex commentForm trueComment">
                    <textarea name="comentario" placeholder="Seu comentário..."></textarea>
                    <input type="submit" name="postComment" id="submitComment" style="display:none;">
                    <input type="hidden" name="postId" value="<?=$value['id']?>">
                    <input type="hidden" name="ownerId" value="<?=$value['id_user']?>">
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

                        <div class="actionBtn flex commentActions" idComment="<?=$value['id']?>" ownerId="<?=$value['user_id']?>">
                            <button class="like-comment" "><i  class="fa-regular fa-heart"></i><span>0</span></button>
                            <button class="reply" ><i class="fa-solid fa-reply"></i></button>
                            <button class="show"><span class="status">Mostrar</span> Resposta (<span class="quantity"><?= models\feedModel::getReplyQuantity($value['id']) ?></span>)</button>
                        </div><!--actionBtn-->        
                    </div><!--comentSingle-->
                <?php } ?>
                </div>
            </div>
        </div><!--Post-single-->
    <?php }} ?>

    </section><!--Posts-->
    <?php
        $fotosStr = site::getFotos();
        $fotos = [];
        foreach ($fotosStr as $key => $value) {
            $fotoStrSingle = explode('<-!->',$value['images']);
            foreach ($fotoStrSingle as $key => $value2) {
                $fotos[] = $value2;
            }
        }
        if(count($fotos) != 0){
    ?>
    <section class="myPhotos">
        <p>Suas Fotos</p>
        <div class="images flex">
            <?php
                $quant = count($fotos) >= 4 ? 4 : count($fotos);
                for ($i=0; $i < $quant; $i++) { 
                   
            ?>
            <div class="image">
                <img src="<?=PATH.'uploads/'.$fotos[$i]?>">
            </div>
            <?php } ?>
        </div>
    </section>
    <?php } ?>
</div>