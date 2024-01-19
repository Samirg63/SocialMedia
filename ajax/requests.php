<?php
include('../config.php');

    //ACTION 1
        if($_POST['action1'] == 'attFoto'){

            //deleteOldFoto
            $foto = Mysql::conectar()->prepare('SELECT img FROM `tb_admin.usuarios` WHERE id=?');
            $foto->execute([$_SESSION['id']]);
            $foto = $foto->fetch()['img'];
            unlink(BASE_DIR.'/uploads/'.$foto);

            //new Foto
            $img = $_POST['img'];
            $sql = Mysql::conectar()->prepare('UPDATE `tb_admin.usuarios` SET img = ? WHERE id = ?');
            $sql->execute([$img,$_SESSION['id']]);
        }else if($_POST['action1'] == 'addFriend'){
            //CHECAR SE JA EXISTE SOLICITAÇÃO
            
            $check = Mysql::conectar()->prepare('SELECT * FROM `tb_site.solicitacoes` WHERE id_to = ? AND id_from = ? AND status = ?');
            $check->execute([$_SESSION['id'],$_POST['id_to'],0]);

            if($check->rowCount() == 0){
                $addFriend = Mysql::conectar()->prepare('INSERT INTO `tb_site.solicitacoes` VALUES(null,?,?,?)');
                $addFriend->execute([$_SESSION['id'],$_POST['id_to'],0]);
    
                $notification = Mysql::conectar()->prepare('INSERT INTO `tb_site.notificacoes` VALUES(null,?,?,?,?)');
                $notification->execute([$_SESSION['id'],$_POST['id_to'],'amizade',0]);
            }else{
                $accept = Mysql::conectar()->prepare('UPDATE `tb_site.solicitacoes` SET status = ? WHERE id_to=? AND id_from=?');
                $accept->execute([1,$_SESSION['id'],$_POST['id_to']]);

                $changeNotificacation = Mysql::conectar()->prepare('UPDATE `tb_site.notificacoes` SET action=? AND view=? WHERE id_from = ? AND id_to = ?');
                $changeNotificacation->execute(['amizadeAceita',0,$_POST['id_to'],$_SESSION['id']]);

                $createNotification = Mysql::conectar()->prepare('INSERT INTO `tb_site.notificacoes` VALUES(null,?,?,?,?)');
                $createNotification->execute([$_SESSION['id'],$_POST['id_to'],'amizadeAceita',0]);
            }

            die();
        }else if($_POST['action1'] == 'seeNotification'){
            $sql = Mysql::conectar()->prepare('UPDATE `tb_site.notificacoes` SET view = ? WHERE id_to = ?');
            $sql->execute([1,$_SESSION['id']]);
            die();
        }else if($_POST['action1'] == 'acceptAmizade'){
            $sql = Mysql::conectar()->prepare('UPDATE `tb_site.solicitacoes` SET status = ? WHERE id_from = ? AND id_to = ?');
            $sql->execute([1,$_POST['id_from'],$_SESSION['id']]);

            $changeNotificacation = Mysql::conectar()->prepare('UPDATE `tb_site.notificacoes` SET action=? WHERE id_from = ? AND id_to = ?');
            $changeNotificacation->execute(['amizadeAceita',$_POST['id_from'],$_SESSION['id']]);

            $createNotification = Mysql::conectar()->prepare('INSERT INTO `tb_site.notificacoes` VALUES(null,?,?,?,?)');
            $createNotification->execute([$_SESSION['id'],$_POST['id_from'],'amizadeAceita',0]);

            die();
        }else if($_POST['action1'] == 'cancelAmizade'){
            $sql = Mysql::conectar()->prepare('DELETE FROM `tb_site.solicitacoes` WHERE id_to=? AND id_from = ?');
            $sql->execute([$_SESSION['id'],$_POST['id_from']]);
            
            //DELETAR notificacao
            $sql = Mysql::conectar()->prepare('DELETE FROM `tb_site.notificacoes` WHERE id_to=? AND id_from = ?');
            $sql->execute([$_SESSION['id'],$_POST['id_from']]);
            
        }else if($_POST['action1'] == 'addLike'){
            $sql = Mysql::conectar()->prepare('INSERT INTO `tb_admin.likes` VALUES(null,?,?)');
            $sql->execute([$_SESSION['id'],$_POST['post']]);

            $sql = Mysql::conectar()->prepare('UPDATE `tb_site.posts` SET likes = ? WHERE id = ?');
            $sql->execute([$_POST['likes'],$_POST['post']]);
        }
        else if($_POST['action1'] == 'removeLike'){
            $sql = Mysql::conectar()->prepare('DELETE FROM `tb_admin.likes` WHERE id_user = ? AND id_post = ?');
            $sql->execute([$_SESSION['id'],$_POST['post']]);

            $sql = Mysql::conectar()->prepare('UPDATE `tb_site.posts` SET likes = ? WHERE id = ?');
            $sql->execute([$_POST['likes'],$_POST['post']]);
        }else if($_POST['action1'] == 'postComment'){
            $sql = Mysql::conectar()->prepare('INSERT INTO `tb_site.comments` VALUES(null,?,?,?)');
            $sql->execute([$_POST['content'],$_POST['postId'],$_SESSION['id']]);
            //att numero de comentarios
            $sql = Mysql::conectar()->prepare('UPDATE `tb_site.posts` SET comments=? WHERE id=?');
            $sql->execute([$_POST['commentQuant'],$_POST['postId']]);
            

            //Informações do usuario par inserção dinâmica
            $sql = Mysql::conectar()->prepare('SELECT user,img FROM `tb_admin.usuarios` WHERE id = ?');
            $sql->execute([$_SESSION['id']]);
            die(json_encode($sql->fetch()));
        }else if($_POST['action1'] == 'deletefriend'){
            $sql = Mysql::conectar()->prepare('DELETE FROM `tb_site.solicitacoes` WHERE (id_from = ? AND id_to = ?) OR (id_from = ? AND id_to = ?)');
            $sql->execute([$_POST['idfriend'],$_SESSION['id'],$_SESSION['id'],$_POST['idfriend']]);
            
            //deletar notificacao
            $sql = Mysql::conectar()->prepare('DELETE FROM `tb_site.notificacoes` WHERE (id_from = ? AND id_to = ?) OR (id_from = ? AND id_to = ?)');
            $sql->execute([$_POST['idfriend'],$_SESSION['id'],$_SESSION['id'],$_POST['idfriend']]);
            
            die();
        }else if($_POST['action1'] == 'deletePost'){
            //Deletar Fotos
            $sql = Mysql::conectar()->prepare('SELECT images FROM `tb_site.posts` WHERE id = ?');
            $sql->execute([$_POST['idPost']]);
            $images = $sql->fetch()['images'];
            $images = explode('<-!->',$images);
            
            foreach ($images as $key => $value) {
                site::deleteFile($value);
            };

            //Deletar Posts
            $sql = Mysql::conectar()->exec("DELETE FROM `tb_site.posts` WHERE id = $_POST[idPost]");

            //Deletar comentarios
            $sql = Mysql::conectar()->exec("DELETE FROM `tb_site.comments` WHERE post_id = $_POST[idPost]");
            
            //deletar likes
            $sql = Mysql::conectar()->exec("DELETE FROM `tb_admin.likes` WHERE id_post = $_POST[idPost]");

            die();
        }else if($_POST['action1'] == 'searchFriend'){
            $sql = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE user LIKE '%$_POST[user]%'");
            $sql->execute();
            $all = $sql->fetchAll();
            $search = [];

            //retirar ja amigos da pesquisa

            $ids = models\friendsModel::getFriendsId($_SESSION['id']);
            foreach ($all as $key => $value) {
                $new = true;
                if($value['id'] == $_SESSION['id']){
                    continue;
                }
                foreach ($ids as $key => $value2) {
                    if($value['id'] == $value2){
                        $new = false;
                    }
                }
                if($new){
                    //Checar se ja existe solicitacao
                    $sql = Mysql::conectar()->prepare('SELECT * FROM `tb_site.solicitacoes` WHERE (id_from = ? AND id_to = ?) OR (id_to = ? AND id_from = ?)');
                    $sql->execute([$value['id'],$_SESSION['id'],$value['id'],$_SESSION['id']]);
                    if($sql->rowCount() == 0){
                        $value['solicitacao'] = false;
                    }else{
                        $value['solicitacao'] = true;
                    }
                    $search[] = $value;
                }
            }

            die(json_encode($search));
        }else if($_POST['action1'] == 'checkCode'){
            if($_POST['code'] == $_SESSION['code'])
                die('true');
            else
                die('false');
            
        }else if($_POST['action1'] == 'createAccount'){
            $login = new controllers\loginController();
            $login->createAccount($_SESSION['temp_nome'],$_SESSION['temp_nascimento'],$_SESSION['temp_senha'],$_SESSION['temp_genero'],$_SESSION['temp_user'],$_SESSION['temp_email']);
            die();
        }

    //ACTION 2
    if(isset($_POST['action2'])){
        if($_POST['action2'] == 'confirmUpload'){
            site::confirmUpload();
        }
    }
    
?>