
<?php
    $infoPerfil = models\perfilModel::getInfoPerfil();
    addCss($arr2['css']);
    addComponents($arr2['component']);
?>
<div class="editFormContainer">
    <form class="editFotoForm form-primary" method="post" enctype="multipart/form-data">
        <div class="top">
            <?php if(!isset($_FILES['foto'])){?><button class="closePopUp"><i class="fa-solid fa-x"></i></button><?php }else{?><button class="cancel closePopUp">Cancelar</button> <?php } ?>
        <h3>Mudar Foto de perfil</h3>
        <?php if(!isset($_FILES['foto'])){?><input class="editFotoSubmit" type="submit" name="acao" value="Confirmar"><?php }else{?><a class="confirmEdit">Confirmar</a> <?php } ?>
    </div>
    <div class="fields flex">
        <input type="file" name="foto" id="fotoInput" style="display:none;">
        <label for="fotoInput"><i class="fa-solid fa-image"></i></label>
        <h4>Selecione uma nova foto</h4>
    </div>
    <div class="imgPreview flex">
        <div class="preview">
            <img src="">
        </div>
    </div>    
    </form>
    
</div>

<div class="editPerfilContainer">
    <form class="editPerfilForm form-primary" method="post" >
        <div class="top">
           <button class="closePopUp"><i class="fa-solid fa-x"></i></button>
            <h3>Editar Perfil</h3>
            <input class="editPerfilSubmit" type="submit" name="acao" value="Confirmar">
        </div><!--top-->
    <div class="flex">

        <div class="field">
            <h4>Sua bio</h4>
            <div class="textareaField">
                <textarea name="bio" class="bioForm" placeholder="Sua Bio..."><?=$infoPerfil['bio']?></textarea>
                <span class="caracCounter flex">255/<p>0</p></span>
            </div>
        </div><!--field-->
        <div class="field">
            <div class="group">
                <h4>Mudar nome de usuário:</h4>
                <input type="text" name="user" placeholder="Nome de Usuário..." value="<?=$infoPerfil['user']?>">
            </div>
            <div class="group">
                <h4>Mudar Senha:</h4>
                <div class="passwordBox">
                    <input type="password" name="senha" placeholder="Senha..." >
                    <label class="showPassword"><i class="fa-regular fa-eye"></i></label>
                </div>
            </div>
        </div><!--field-->
        </div><!--flex-->
    </form>
    
</div>
<openpreview <?php if(isset($_FILES['foto'])){echo 'open="open"';}?> ></openpreview>

<section class="user container">
    <div class="userInfo flex">

        <div class="imgPerfil flex">
            <?php if($infoPerfil['img'] != ''){?>
                <img src="<?=PATH.'uploads/'.$infoPerfil['img'];?>">
            <?php }else{ ?>
                <img src="<?=PATH.'assets/avatar-placeholder.jpg'?>">
            <?php } ?>
        <div class="editFoto">
            <i class="fa-solid fa-image"></i>
            <p>Mudar Foto</p>
        </div>
        </div>

        <div class="info flex">
            <div class="group">
                <h2><?=ucfirst($infoPerfil['user']);?></h2>
                <div class="bio">
                    <?=$infoPerfil['bio']?>
                </div>
            </div>
            <button class="editPerfil">Editar Perfil</button>
        </div>
    </div>
    <?php
    //ativar carrosel com 6 imagens
     $fotosStr = site::getFotos();
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
<section class="perfilcontent">
        <?php
            $userInfoController = new controllers\userInfoController();
            $friendsController = new controllers\friendsController();

            Router::get('/home/perfil',function() use ($userInfoController){
                $userInfoController->index();
            });

            
            Router::get('/home/perfil/amigos/',function() use ($friendsController){ 
                $friendsController->index();
            });

            Router::get('/home/perfil/addAmigos',function() use ($friendsController){ 
                $friendsController->index2();
                
            });

            Router::get('/home/perfil/?',function($par) use ($userInfoController){
                if($par[3] != 'amigos' && $par[3] != 'addAmigos'){
                    $userInfoController->index();
                }
            });

            
            
        ?>
</section>