<div class="overlayFix"></div>

            <?php
                $value = models\homeModel::getPostInfo($_GET['editPost']);
            ?>
<div class="float" style="width: 900px;">
    <div class="postSingle">

        <div class="user flex">
            <div class="img">
                <?php if($_SESSION['img'] != ''){?>
                        <img src="<?=PATH.'uploads/'.$_SESSION['img']?>">
                    <?php }else{ ?>
                        <img src="<?=PATH.'assets/avatar-placeholder.jpg'?>">
                    <?php } ?>
                </div>
                <div class="userInfo">
                    <p><a href="<?=PATH_HOME?>perfil/<?=$_SESSION['login']?>"><?=$_SESSION['login']?></a></p>
                    <span><?=$value['data']?></span>
                </div>
            </div>

            <div class="info">
                <form action="" method="post">
                    <textarea name="conteudo" placeholder="Conteúdo..."><?=$value['content'] ?></textarea>
                </form>
                
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


            
        </div><!--Post-single-->
    </div>
        
        