<?php
    namespace controllers;

    class forgotPasswordController{

        public function enviarEmail($login,$token){
            $mail = new \Email('smtp.gmail.com','sender63g@gmail.com','yczqfghinrqapabx','Samir');
            $info = ['assunto'=>'Redifinir a senha da conta no SocialMedia','corpo'=>'Foi solicitado uma troca de senha da sua conta SocialMedia, segue a baixo o link para prosseguir: <br> <a href="'.PATH.'esqueci-minha-senha?token='.$token.'&email='.$login.'">Redefinir Senha!</a>'];
            $mail->formatarEmail($info);
            $mail->addAdress($login,null);
            if($mail->sendMail())
                return true;
            else   
                return false;
        }

        public function index(){
            if(isset($_POST['confirmEmail'])){
                if(!filter_var($_POST['confirmEmail'], FILTER_VALIDATE_EMAIL)){
                    echo '<script>alert("Insira um e-mail valido!")</script>';
                    \site::redirect(PATH.'esqueci-minha-senha');
                    die();
                }else{
                    //Validar se o email existe na database
                    $sql = \Mysql::conectar()->prepare('SELECT * FROM `tb_admin.usuarios` WHERE login=?');
                    $sql->execute([$_POST['confirmEmail']]);
                    if($sql->rowCount() == 0){
                        echo '<script>alert("Esse e-mail não esta cadastrado no site")</script>';
                        \site::redirect(PATH.'esqueci-minha-senha');
                        die();
                    }
                }
                
                //Enviar email
                $token = uniqid();
                if($this->enviarEmail($_POST['confirmEmail'],$token)){
                    $sql = \Mysql::conectar()->prepare('INSERT INTO `tb_admin.requestNewPassword` VALUES(null,?,?)');
                    $sql->execute([$token,date('Y-m-d',time())]);
                }
            }

            if(isset($_POST['changePassword'])){
                //Validar se as senhas estão iguais
                $senha1 = $_POST['senha'];
                $senha2 = $_POST['senhaRep'];
                if($senha1 != $senha2){
                    echo '<script>alert("As senhas devem estar iguais")</script>';
                }else{
                    $email = $_GET['email'];
                    $senha = \Bcrypt::hash($senha1);
                    $sql = \Mysql::conectar()->prepare('UPDATE `tb_admin.usuarios` SET senha = ? WHERE login=?');
                    $sql->execute([$senha,$email]);
                    echo '<script>alert("Senha alterada com sucesso!")</script>';
                    \site::redirect(PATH);
                    die();
                }
            }

            \views\mainview::render('forgotPassword');
        }
    }
?>