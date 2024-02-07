<div class="overlayFix"></div>
<section class="editor">
<?php
addComponents($arr2['component']);
$url = $_GET['url'];
$url = explode('/',$url);
$page = $url[count($url) - 1];
?>
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="commentId" value="<?=$_GET['editComment']?>">

            <?php
                $value = models\homeModel::getCommentInfo($_GET['editComment']);
            ?>
<div class="float form-primary" style="width: 900px;">
    <div class="top">
        <button class="closePopUp deleteEditor"><i class="fa-solid fa-x"></i></button>
        <h3>Editar comentario</h3>
        <input class="editCommentSubmit" type="submit" name="" value="Editar">
    </div>
    <div class="fields">
        <textarea name="commentContent" class="w100" class="commentText" placeholder="Conteudo..."><?=$value['content']?></textarea> 
    </div>
</div>
</section>        
        