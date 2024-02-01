<?php
    addComponents($arr2['component']);
?>
<div class="overlayFix"></div>
<section class="autenticateBox flex" >
    <div class="centerbox">
        <small></small>
        <p>Um código foi enviado para: <b><?=$_SESSION['temp_email']?></b>, insíra o código abaixo:</p>
        <input type="text" name="code" placeholder="______" formato="code" class="authCode">
        <a href="<?=PATH.'login?resend'?>">Reenviar E-mail</a>
    </div>
</section>
