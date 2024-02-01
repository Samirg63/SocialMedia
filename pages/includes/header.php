<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if(models\homeModel::checkNewNotification()){echo '('.models\homeModel::checkNewNotification().') ';}?>Social Media</title>
    <script src="<?=PATH?>js/JQuery.js"></script>
    <link rel="stylesheet" href="<?=PATH?>css/global-style.min.css">
    <link rel="stylesheet" href="<?=PATH?>css/header-style.min.css">
    <link rel="stylesheet" href="<?=PATH?>css/all.min.css">
    <link rel="stylesheet" href="<?=PATH?>css/components/formulario.min.css">
    <?php
    if(isset($arr['css'])){
        foreach ($arr['css'] as $key => $value) {
            if(file_exists(BASE_DIR.'/css/'.$value.'-style.min.css')){
                echo '<link rel="stylesheet" href="'.PATH.'css/'.$value.'-style.min.css">';
            }else if(file_exists(BASE_DIR.'/css/'.$value.'-style.css')){
                echo '<link rel="stylesheet" href="'.PATH.'css/'.$value.'-style.css">';
            }
        }
    }
    if(isset($arr['component'])){
        foreach ($arr['component'] as $key => $value) {
            if(file_exists(BASE_DIR.'/css/components/'.$value.'.min.css')){
                echo '<link rel="stylesheet" href="'.PATH.'css/components/'.$value.'.min.css">';
            }else if(file_exists(BASE_DIR.'/css/components/'.$value.'.css')){
                echo '<link rel="stylesheet" href="'.PATH.'css/components/'.$value.'.css">';
            }
        }
    }
    
    ?>
</head>
<body>
    <path path="<?=PATH?>"></path>
    <?php if(isset($_SESSION['id'])){?><user userId="<?=$_SESSION['id']?>"></user><?php } ?>
    <div class="overlay"></div>
    <form method="post" class="clearForm">
        <input type="hidden" name="clear" value="limpaTudo">
    </form>
    <div class="createPostContainer">

        <form method="post" class="newPost form-primary" enctype="multipart/form-data">
            <?php if(isset($_POST['acao']) && $_POST['acao'] == 'seePreview' && isset($_SESSION['previewImgs'])){echo '<div class="lock" style="display:none;">-</div>';}?>
            <div class="top">
                <button class="closePopUp"><i class="fa-solid fa-x"></i></button>
                <h3>Criar nova publicação</h3>
                <input class="createPost" type="submit" name="" value="Publicar">
            </div> 
            
            
            <div class="fields flex">
                <div class="imageField flex"> 
                    <input type="hidden" name="acao" value="<?php if(isset($_POST['acao']) && $_POST['acao'] == 'seePreview'){ echo 'seePreview';}else{echo 'acaoNoPhoto';}   ?>">
                    <?php
                    if(!isset($_POST['acao'])){
                        ?>  
                        <label for="images"><i class="fa-regular fa-images"></i></label>
                        <h5>Adicione imagens</h5>
                        <input id="images" type="file" name="fotos[]" style="display:none;" multiple="multiple">
                    <?php }else{
                        $images = $_SESSION['previewImgs'];
                        ?>
                        <div class="images flex <?php if(count($images) > 1){echo 'carrosel';}?>">
                         <?php foreach ($images as $key => $valueImg) { ?>

                            <div class="image">
                                <button class="remove">X</button>
                                <img src="<?=PATH.'preUploads/'.$_SESSION['id'].'/'.$valueImg?>">
                            </div>

                            <?php } ?>
                        </div>
                        <?php }?>
                </div>


                <textarea name="conteudo" placeholder="Diga o que pensa..."></textarea>
            </div>


        </form>
        
    </div>
    
    <div class="enableBackgroud" style="opacity:0;">.</div>
<?php
    if(isset($_POST['clear'])){
    $dir = scandir(BASE_DIR.'/preUploads/'.$_SESSION['id']);
    foreach ($dir as $key => $value) {
        if($value == '.' || $value == ".."){
            continue;
        }
        @unlink(BASE_DIR.'/preUploads/'.$_SESSION['id'].'/'.$value);
    }
    @rmdir(BASE_DIR.'/preUploads/'.$_SESSION['id']);
    }
?>