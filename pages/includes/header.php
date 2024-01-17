<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Media</title>
    <link rel="stylesheet" href="<?=PATH?>css/style.min.css">
    <link rel="stylesheet" href="<?=PATH?>css/all.min.css">
    <script src="<?=PATH?>js/JQuery.js"></script>
</head>
<body>
    <path path="<?=PATH?>"></path>
    <?php if(isset($_SESSION['id'])){?><user userId="<?=$_SESSION['id']?>"></user><?php } ?>
    <div class="overlay"></div>
    <form method="post" class="clearForm">
        <input type="hidden" name="clear" value="limpaTudo">
    </form>
    <div class="createPostContainer">

        <form method="post" class="newPost" enctype="multipart/form-data">
            <div class="top">
                <button class="closePopUp"><i class="fa-solid fa-x"></i></button>
                <h3>Criar nova publicação</h3>
                <input class="createPost" type="submit" name="acao" value="Publicar">
            </div>    
            <div class="fields flex">
                <div class="imageField flex">    
                    <label for="images"><i class="fa-regular fa-images"></i></label>
                    <h5>Adicione imagens</h5>
                    <input id="images" type="file" name="fotos[]" style="display:none;" multiple="multiple">
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