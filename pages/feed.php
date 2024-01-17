<?php
    
    $posts = models\feedModel::getPosts();
    
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