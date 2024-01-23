<?php
    namespace controllers;

    class loginController{
    
        
        public function autenticateBox(){
            
            include('pages/includes/autenticateBox.php');
        }   
        
        public function createAccount($nome,$nascimento,$senha,$genero,$user,$login){
            $sql = \Mysql::conectar()->prepare('INSERT INTO `tb_admin.usuarios` VALUES(null,?,?,?,?,?,?,?,?,?)');
            $sql->execute([$nome,$nascimento,$genero,$user,$login,$senha,'','','']);
            $id = \MySql::conectar()->lastInsertId();
            $img = ''; #ADICIONAR SISTEMA DE IMAGEM
            session_destroy();
            $_SESSION['login'] = $login;
            $_SESSION['id'] = $id;
            $_SESSION['user'] = $user;
            
        }
        
        public function index(){
            #REENVIAR EMAIL
            if(isset($_GET['resend'])){
                $this->enviarEmail($_SESSION['temp_email'],$_SESSION['temp_user']);
            }

            
                
            

            #REGISTRAR
            if(isset($_POST['registrar'])){
                $nome = $_POST['nome'];
                $nascimento = $_POST['nascimento'];
                $genero = $_POST['genero'];
                $user = $_POST['user'];
                $login = $_POST['login'];
                //senha critografada
                $senha = \Bcrypt::hash($_POST['senha']);

                $continue = true;

                if(preg_match('/[a-z]/',$login)){
                    #é email
                    $is_email = true;
                    if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
                        $continue = false;
                    }else{
                        //Validar Email
                        
                        if($this->enviarEmail($login,$user)){
                            $_SESSION['temp_email'] = $login;
                            $_SESSION['temp_user'] = $user;
                            $_SESSION['temp_senha'] = $senha;
                            $_SESSION['temp_nome'] = $nome;
                            $_SESSION['temp_genero'] = $genero;
                            $_SESSION['temp_nascimento'] = $nascimento;
                            $this->autenticateBox();
                        }
                    }
                }

                if($continue){
                    if(!$is_email){      
                        $this->createAccount($nome,$nascimento,$senha,$genero,$user,$login);
                    }
                    
                }else{
                    echo '<script>alert("E-mail invalido")</script>';
                }
            }

            if(isset($_POST['logar'])){
                $login = $_POST['login'];
                $senha = $_POST['senha'];
                if($login == '' || $senha == ''){
                    echo '<script>alert("Preencha todos os campos!")</script>';
                }else{

                    $sql = \Mysql::conectar()->prepare('SELECT * FROM `tb_admin.usuarios` WHERE login = ?');
                    $sql->execute([$login]);
                    $info = $sql->fetch();                   
                    
                    if(\Bcrypt::check($senha,$info['senha'])){
                        #SUCESSO
                        \site::login($info['user'],$info['id'],$info['img']);
                    }else{
                        #ERRO
                        echo '<script>alert("Usuario ou senha incorretos...")</script>';
                    }
                }
            }
            \views\mainview::render('login');
        }

        public function enviarEmail($login,$user){
            $mail = new \Email('smtp.gmail.com','sender63g@gmail.com','yczqfghinrqapabx','Samir');
            $code = \models\loginModel::generateCode();
            $_SESSION['code'] = $code;
            $info = ['assunto'=>'Autenticação de E-mail para criação de conta no SocialMedia','corpo'=>'O seu códido de autenticação é:<br/><h2 style="text-align:center;">'.$code.'</h2>'];
            $mail->formatarEmail($info);
            $mail->addAdress($login,$user);
            if($mail->sendMail())
                return true;
            else   
                return false;
}
    }
?>