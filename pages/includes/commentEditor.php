<div class="overlayFix"></div>
<section class="editor">
<?php
addComponents($arr2['component']);
$url = $_GET['url'];
$url = explode('/',$url);
$page = $url[count($url) - 1];

$id = isset($_GET['editComment']) ? $_GET['editComment'] : $_GET['editReply'];
?>
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="commentId" value="<?=$id?>">

            <?php
            if(isset($_GET['editComment'])){
                $value = models\homeModel::getCommentInfo($id);
            }else{
                $value = models\homeModel::getReplyInfo($id);
            }
            ?>
<div class="float form-primary" style="width: 900px;">
    <div class="top">
        <button class="closePopUp deleteEditor"><i class="fa-solid fa-x"></i></button>
        <h3>Editar comentario</h3>
        <input class="<?php if(isset($_GET['editComment'])){echo 'editCommentSubmit';}else{echo 'editReplySubmit';}?>" type="submit" name="" value="Editar">
    </div>
    <div class="fields">
        <textarea name="commentContent" class="w100" class="commentText" placeholder="Conteudo..."><?=$value['content']?></textarea> 
    </div>
</div>
</section>        
        