<section class="forgotPassword center">
    <?php
        if(!isset($_POST['confirmEmail'])){
    ?>
        <h2>Redefinir minha Senha:</h2>
        <?php
        if(!isset($_GET['token'])){
        ?>
        <form method="post">
            <div class="group">
                <label for="">Insira seu e-mail:</label>
                <input type="text" name="confirmEmail" placeholder="E-mail..." required>
            </div>
            <input type="submit" value="Prosseguir">
        </form>
        <?php }else{ 
        if(!models\forgotPasswordModel::validateToken($_GET['token'],$_GET['email'])){
            echo '<script>alert("Endereço Inválido!")</script>';
            site::redirect(PATH.'esqueci-minha-senha');
            die();
        }    
        ?>
        <form method="post">
            <div class="group">
                <label for="">Insira sua nova senha:</label>
                <div class="passwordBox">
                    <input type="password" name="senha" placeholder="Senha...">
                    <label class="showPassword"><i class="fa-regular fa-eye"></i></label>
                </div>   
            </div>
            <div class="group">
                <label for="">Insira novamente a senha:</label>
                <div class="passwordBox">
                    <input type="password" name="senhaRep" placeholder="Senha...">
                    <label class="showPassword"><i class="fa-regular fa-eye"></i></label>
                </div>   
            </div>
            <input type="submit" value="Prosseguir" name="changePassword">
        </form>
        <?php } ?>
    <?php }else{ ?>
         
    

        <span>Um e-mail foi enviado para: <b><?=$_POST['confirmEmail']?></b>, Verifique para prosseguir!</span>
    <?php } ?>
</section>
<script src="<?=PATH?>js/script.js"></script>