<section class="flex loginBox center">
    <div class="info">
        <h1>Social.Media</h1>
        <p>Conecte-se com seus amigos e expanda seus aprendizados com a rede social Danki Code.</p>
    </div>
    <?php
    if(!isset($_GET['register'])){
        #FORM LOGIN
    ?>
    <form method="post">
        <input type="text" name="login" placeholder="E-mail ou telefone">
        <div class="passwordBox">
            <input type="password" name="senha" placeholder="Senha">
            <label class="showPassword"><i class="fa-regular fa-eye"></i></label>
        </div>
        <input type="submit" value="Entrar" name="logar">
        <a href="<?=PATH.'/login?register'?>">criar nova conta</a>
    </form>
    <?php }else{
        #FORM Registrar    
    ?>
    <form method="post">
        <input type="text" name="nome" placeholder="Nome completo">
        <div class="flex">
            <input type="text" name="nascimento" formato="data" placeholder="Data de nascimento">
            <select name="genero">
                <option value="null">Gênero</option>
                <option value="M">Masculino</option>
                <option value="F">Feminino</option>
                <option value="unidentified">Não identificar</option>
            </select>
        </div>
        <input type="text" name="user" placeholder="Usuário">
        <input type="text" name="login" placeholder="E-mail ou telefone">
        <div class="passwordBox">
            <input type="password" name="senha" placeholder="Senha">
            <label class="showPassword"><i class="fa-regular fa-eye"></i></label>
        </div>
        <input type="submit" value="Criar conta e entrar" name="registrar">
        <a href="<?=PATH.'/login'?>">Já tenho uma conta</a>
    </form>
    <?php } ?>
</section>

<script src="<?=PATH?>js/jquery.mask.min.js"></script>
<script src="<?=PATH?>js/mascaras.js"></script>
<script src="<?=PATH?>js/script.js"></script>