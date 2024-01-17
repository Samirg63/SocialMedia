
<?php
    $friends = models\friendsModel::getFriends()
    
?>
    <h2 class="friendTitle"><?php if($arr['page'] == 'amigos'){echo 'Amigos';}else{echo 'Busque novos amigos';}?></h2>
    <?php if($arr['page'] != 'amigos'){?>
        <form method="post" class="searchForm">
            <input type="search" name="searchUser" placeholder="Busque novos amigos...">
        </form>
    <?php } ?>
<section class="friends container">

    <div class="amigos flex">
    <?php if($arr['page'] == 'amigos'){
            foreach ($friends as $key => $value) {      
        ?>
        <div class="amigoSingle flex" idFriend="<?=$value['id']?>">
            <div class="flex">

                <div class="img">
                    <?php if($value['img'] != ''){?>
                        <img src="<?=PATH.'uploads/'.$value['img'];?>" alt="">
                    <?php }else{ ?>
                        <img src="<?=PATH.'assets/avatar-placeholder.jpg'?>">
                    <?php } ?>
                </div>
                <div class="info">
                    <p><a href="<?=PATH_HOME.'perfil/'.$value['user']?>"><?=$value['user']?></a></p>
                    <span>Cidade</span>
                </div>
            </div>
            <button class="deleteFriend"><i class="fa-regular fa-trash-can"></i></button>
        </div><!--amigoSingle-->
        <?php }}else{
         $newFriends = \models\friendsModel::getNewFriends($_SESSION['id']);
         $waitingResponse = \models\friendsModel::getWaiting($_SESSION['id']);
         foreach ($newFriends as $key => $value){
            $amigos = false;
            foreach ($waitingResponse as $key => $value2) {
                if($value['id'] == $value2){
                    $amigos = true;
                }
            }         
        ?>


        <div class="amigoSingle add flex" idUser="<?=$value['id']?>">
            <div class="img">
                <?php
                    if($value['img'] != ''){
                ?>
                <?php if($value['img'] != ''){?>
                    <img src="<?=PATH.'uploads/'.$value['img']?>" alt="">
                <?php }else{ ?>
                    <img src="<?=PATH.'assets/avatar-placeholder.jpg'?>">
                <?php } ?>
                <?php } ?>
            </div>
            <div class="flex">
                <div class="info">
                    <p><a href="<?=PATH_HOME.'perfil/'.$value['user']?>"><?=$value['user']?></a></p>
                    <span>Cidade</span>
                </div>
                <button <?php if($amigos){echo 'disabled';}?> class="addFriend"><i class="fa-solid <?php if(!$amigos){?>fa-plus<?php }else{?>fa-check<?php } ?>"></i></button>
            </div>
        </div><!--amigoSingle-->


                <?php }} ?>
        
    </div>

</section>

