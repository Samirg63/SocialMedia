
<section class="userInfo container">
    <h2>Últimas publicações</h2>

    <div class="flex">
        <div class="ultimosPosts">

        <?php
            $posts = models\userInfoModel::getMyPosts();
            $userInfo = site::getUserInfo($_SESSION['id']);
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
                    <p><?=$userInfo['user']?></p>
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
                <button class="like" title="<?=$value['likes'] ?>"><i style="<?php if(site::hasLiked($value['id'])){echo 'color:#ff8787;';}?>" class="<?php if(site::hasLiked($value['id'])){echo 'fa-solid';}else{echo 'fa-regular';}?> fa-heart"></i><span><?=$value['likes'] ?></span></button>
                <button class="comment" title="<?=$value['comments'] ?>"><i class="fa-regular fa-comment"></i><span><?=$value['comments'] ?></span></button>
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
                    <div class="commentSingle flex">
                        <div class="commentImg">
                        <?php if($userInfoComment['img'] != ''){?>
                            <img src="<?=PATH.'uploads/'.$userInfoComment['img']?>">
                        <?php }else{ ?>
                            <img src="<?=PATH.'assets/avatar-placeholder.jpg'?>">
                        <?php } ?>
                        </div>
                        <div class="commentInfo">
                            <p><?=$userInfoComment['user']?></p>
                            <span><?=$value['content']?></span>
                        </div>                
                    </div><!--comentSingle-->
                <?php } ?>
                </div>
            </div>
        </div><!--Post-single-->

            <?php } ?>

        </div>

        <section class="myFriends">
        <p>Amigos</p>
        <div class="amigos">
        <?php
            $friends = models\friendsModel::getFriends();
            if(count($friends) == 0){
                echo '<h4 style="color:#454545;">Ops... Parece que você não tem amigos</h4>';
            }else{
            foreach ($friends as $key => $value) {
                
        ?>
            <div class="amigoSingle flex">
                <div class="amigoImg">
                    <?php if($value['img'] != ''){?>
                        <img src="<?=PATH. 'uploads/'.$value['img']?>">
                    <?php }else{ ?>
                        <img src="<?=PATH.'assets/avatar-placeholder.jpg'?>">
                    <?php } ?>
                </div>
                <div class="amigoInfo">
                    <p><a href="<?=PATH_HOME.'perfil/'.$value['user']?>"><?=$value['user']?></a></p>
                    <span>cidade</span>
                </div>
            </div><!--amigoSingle-->
        <?php }} ?>
        
            <a href="<?=PATH_HOME?>perfil/amigos">Ver Mais</a>
        </div>
    </section>
    </div>
</section>