$(function(){
    

    const path = $('path').attr('path');
    const userId = $('user').attr('userId');

    //MOSTRAR SENHA
    $('.showPassword').click(function(){
        let icon = $(this).find('i');
        if(icon.hasClass('fa-eye')){
            icon.removeClass('fa-eye');
            icon.addClass('fa-eye-slash');

            $('input[name=senha]').attr('type','text');
        }else{
            icon.removeClass('fa-eye-slash');
            icon.addClass('fa-eye');
            $('input[name=senha]').attr('type','password');
        }
    })

    //ADICIONAR AMIGO
    $('.amigos').on('click','.amigoSingle .flex button',function(){
        let container = $(this);
        $(this).find('i').removeClass('fa-plus');
        
        let id_to = $(this).parent().parent().attr('idUser');
        $.ajax({
            url:'../../ajax/requests.php',
            method:"post",
            data:{id_to:id_to,action1:'addFriend'}
        }).done(function(){
            container.find('i').addClass('fa-check');
            container.attr('disabled','disabled');
        })
    })

    //Animação de like
    $('.like').click(function(){
        let container = $(this);
        let icon = container.find('i')
        let postId = container.parent().attr('idPost');
        let ownerId = container.parent().attr('ownerId');
        if(icon.hasClass('fa-regular')){
            //DAR LIKE
            let likeQuant = parseInt(container.attr('noFormatednumber'));
            $.ajax({
                url:path+'ajax/requests.php',
                method:'post',
                data:{action1:'formatNumber',number:likeQuant+1},
                dataType:'json'  
            }).done(function(data){
                container.find('span').html(data.view);
                container.attr('title',data.hide)
                container.attr('noFormatedNumber',likeQuant+1)
            })
            $.ajax({
                url:path+'ajax/requests.php',
                method:'post',
                data:{action1:'addLike',likes:likeQuant+1,post:postId,ownerId:ownerId}
            }).done(function(){
                icon.removeClass('fa-regular')
                icon.addClass('fa-solid')
                icon.animate({
                    color:'#ff8787'
                },100)
            })
        }else{
            //REMOVER LIKE
            let container = $(this);
            let likeQuant = parseInt(container.attr('noFormatedNumber'));
            $.ajax({
                url:path+'ajax/requests.php',
                method:'post',
                data:{action1:'formatNumber',number:likeQuant-1},
                dataType:'json'  
            }).done(function(data){
                container.find('span').html(data.view);
                container.attr('title',data.hide)
                container.attr('noFormatedNumber',likeQuant-1)
            })
            $.ajax({
                url:path+'ajax/requests.php',
                method:'post',
                data:{action1:'removeLike',likes:likeQuant-1,post:postId,ownerId:ownerId}
            }).done(function(){
                icon.removeClass('fa-solid')
                icon.addClass('fa-regular')
                icon.animate({
                    color:'#D3D8E0'
                },100)
            })
        }
    })

    //ABRIR COMENTARIOS
    $('button.comment').click(function(){
        let comments = $(this).parent().parent().find('.comments')
        if(comments.hasClass('closed')){
            comments.removeClass('closed')
            comments.addClass('open')
        }else{
            comments.addClass('closed')
            comments.removeClass('open')
        }
    })

    //Postar Comentario

    $('.trueComment').on('submit',function(e){
        e.preventDefault();
        let info = $(this).serializeArray()
        let content = info[0].value;
        let postId = info[1].value;
        let trueContainer = $(this).parent().parent();
        let container = $(this).parent().find('.commentsContainer')
        let commentQuant = parseInt(trueContainer.find('button.comment').attr('noFormatedNumber'));
        let ownerId = info[2].value;
        $.ajax({
            url:path+'ajax/requests.php',
            method:"post",
            data:{content:content,postId:postId,commentQuant:commentQuant+1,action1:'postComment',ownerId:ownerId},
            dataType:'json'
        }).done(function(data){

            $('textarea[name=comentario]').val('');
            $.ajax({
                url:path+'ajax/requests.php',
                method:'post',
                data:{action1:'formatNumber',number:commentQuant+1},
                dataType:'json'  
            }).done(function(data){
                trueContainer.find('button.comment').find('span').html(data.view);
                trueContainer.find('button.comment').attr('title',data.hide)
                trueContainer.find('button.comment').attr('noFormatedNumber',commentQuant+1)
            })
            
            
            if(data.img != ''){
                var image = path+'uploads/'+data.img
            }else{
                var image = path+'assets/avatar-placeholder.jpg'
            }
            container.prepend(`
            <div class="commentSingle">
            <div class="flex">
                <div class="commentImg">
                    <img src="${image}">
                </div>
                <div class="commentInfo">
                    <p>${data.user}</p>
                    <span>${content}</span>
                </div>
            </div>
            <div class="actionBtn flex commentActions" idComment="<?=$value['id']?>" ownerId="<?=$value['user_id']?>">
                <button class="like-comment" "><i  class="fa-regular fa-heart"></i><span>0</span></button>
                <button class="reply" ><i class="fa-solid fa-reply"></i></button>
                <button class="show"><span class="status">Mostrar</span> Resposta (<span class="quantity">0</span>)</button>
            </div><!--actionBtn-->  
            
            </div><!--comentSingle-->
            `)
        })

    })

    //Fechar popUps

    function cleanPreUploads(){
        $.ajax({
            method:'post',
            url:'../ajax/destroy.php'
        })
    }

    function fecharPopUp(){
        $('.overlay').hide();
        $('.newPost').hide();
        $('.editFotoForm').hide();
        $('.editPerfilForm').hide();
        $('.full').show();
        $('.resumido').hide();
        $('.notifications').hide();
    }
    $('.overlay , .closePopUp').click(function(e){
        e.preventDefault();
        $('openpreview').removeAttr('open');
        cleanPreUploads();
        fecharPopUp();
    })
    
   
    //Prevent Defauts
    $('.editFotoForm .cancel').click(function(e){
        $('.clearForm').trigger('submit');
        e.preventDefault();
    })


    /*$('.createPostContainer').click(function(e){
        //e.preventDefault();
    })

    $('.editFotoContainer').click(function(e){
        //e.preventDefault();
    })
    $('.editBioContainer').click(function(e){
        //e.preventDefault();
    })*/

    //Submit formulario

    $('.imageField #images').change(function(e){
        if(e.target.files[0]){
            if($('.newPost').find('[name=acao]').attr('value') != 'seePreview'){
                $('.newPost').find('[name=acao]').attr('value','seePreview')
                $('.newPost').trigger('submit');
            }
        }
    })
    
    
    if($('.newPost').find('[name=acao]').attr('value') == 'seePreview' ){
        $('.overlay').show();
        $('.newPost').show();
    }
    
    
    $('.newPost').on('submit',function(){
        if(typeof($('.newPost').find('.lock').html()) != 'undefined'){
            return false;
        }  
    })

    $('.createPost').click(function(){
        $('.lock').remove();
        $('.newPost').find('[name=acao]').attr('value','postPhoto')
        $('.newPost').submit();
    })

    $('.editFotoSubmit').click(function(){
        $('.editFotoForm').submit();
    })

    $('.editPerfilSubmit').click(function(){
        $('.editPerfilForm').submit();
    })

    //Abrir Bio Form

    $('.editPerfil').click(function(){
        $('.overlay').fadeIn();
        $('.editPerfilForm').fadeIn();
    })
    //Criar Post pop-up

    $('.openPost').click(function(){
        fecharPopUp();
        $('.overlay').show();
        $('.newPost').show();

        return false;
    })

    //Mudar foto de perfil pop-up
    $('.imgPerfil').hover(function(){
        $('.editFoto').show();
        $(this).find('img').animate({opacity:0.4},500)
    },function(){
        $('.editFoto').hide();
        $(this).find('img').animate({opacity:1},500)
    })

    $('.imgPerfil').click(function(){
        fecharPopUp();
        $('.overlay').fadeIn();
        $('.editFotoForm').fadeIn();
    })

    //Opacidade foto de perfil

    //Preview Foto de perfil
   if($('openpreview').attr('open')){
        $('.overlay').fadeIn();
        $('.editFotoForm').fadeIn();
        $('.fields').hide();
        $('.imgPreview').css('display','flex');

        let img = $('preview').attr('img');
        $('.preview img').attr('src',path+'preUploads/'+userId+'/'+img)
   }

    $('#fotoInput').change(function(){
        $('.editFotoForm').trigger('submit')
    })

    //Confirmar Edição
    $('.confirmEdit').click(function(e){
        let img = $('preview').attr('img');
        $.ajax({
            url:'../ajax/requests.php',
            method:'post',
            data:{action1:'attFoto',img:img,action2:'confirmUpload'}
        }).done(function(){
            window.location.href=path+"home/perfil"
        })
        e.preventDefault();
    })

    //Abrir/fechar notificações

    $('.openNotification').click(function(){
        $('.full').hide();
        $('.resumido').show();
        $('.notifications').show();
        $(this).find('.badge').remove();

        $.ajax({
            url:'../ajax/requests.php',
            method:'post',
            data:{action1:'seeNotification'}
        })
    })

    $('.closeNotification').click(function(){
        $('.full').show();
        $('.resumido').hide();
        $('.notifications').hide();
    })

    //ACEITAR SOLICITAÇÃO
    $('.notificacaoSingle .accept').click(function(){
        let id_from = $(this).parent().attr('id_from');
        let container =  $(this).parent().parent().parent()
        $.ajax({
            url:path+'ajax/requests.php',
            method:"post",
            data:{id_from:id_from,action1:'acceptAmizade'}
        }).done(function(){
            container.fadeOut(function(){
                container.remove();
            });
        })
    })

    $('.notificacaoSingle .cancel').click(function(){
        let id_from = $(this).parent().attr('id_from');
        let container =  $(this).parent().parent().parent()
        $.ajax({
            url:path+'ajax/requests.php',
            method:"post",
            data:{id_from:id_from,action1:'cancelAmizade'}
        }).done(function(){
            container.fadeOut(function(){
                container.remove();
            });
        })
    })

    //CARROSSEL

    //HABILITAR CARROSEL
    $('div.carrosel').parent().append(`
    <div class="carrosselBtn flex">
        <button class="left"><i class="fa-solid fa-arrow-left"></i></button>
        <button class="right"><i class="fa-solid fa-arrow-right"></i></button>
    </div>
`);
    $('div.carroselPerfil').parent().append(`
    <div class="carrosselBtn flex">
        <button class="left"><i class="fa-solid fa-arrow-left"></i></button>
        <button class="right"><i class="fa-solid fa-arrow-right"></i></button>
    </div>
`);
    


        //feed
            var postWidth = $('.postSingle').width()
            var perfilWidth = $('.user').width();
            var PreviewWidth = $('.images').width();

            
        
            //Avançar
            $('.postSingle .right').click(function(){
                let images = $(this).parent().parent().find('.images')
                let actWidth =  images.scrollLeft();
                let maxWidth = images[0].scrollWidth;
                let nextWidth = actWidth + postWidth;
                if(nextWidth > maxWidth){
                    nextWidth = maxWidth;
                }
                images.animate({
                    scrollLeft:nextWidth+'px'
                },500)
            })

            //Voltar

            $('.postSingle .left').click(function(){
                let images = $(this).parent().parent().find('.images')
                let actWidth =  images.scrollLeft();;
                let nextWidth = actWidth - postWidth;
                if(nextWidth < 0){
                    nextWidth = 0;
                }
                images.animate({
                    scrollLeft:nextWidth+'px'
                },500)
            })
        
        //Perfil

        //Avançar
        $('.user .right').click(function(){
            
            let images = $(this).parent().parent().find('.userPhotos')
            let actWidth =  images.scrollLeft();
            let maxWidth = images[0].scrollWidth;
            let nextWidth = actWidth + perfilWidth;

            if(nextWidth > maxWidth){
                nextWidth = maxWidth;
            }
            images.animate({
                scrollLeft:nextWidth+'px'
            },500)
        })

        //Voltar

        $('.user .left').click(function(){
             
            let images = $(this).parent().parent().find('.userPhotos')
            let actWidth =  images.scrollLeft();;
            let nextWidth = actWidth - perfilWidth;
            if(nextWidth < 0){
                nextWidth = 0;
            }
            images.animate({
                scrollLeft:nextWidth+'px'
            },500)
        })

        //PreviewPost
        //Avançar
        $('.imageField .right').click(function(){
            let images = $(this).parent().parent().find('.images')
            let actWidth =  images.scrollLeft();
            let maxWidth = images[0].scrollWidth;
            let nextWidth = actWidth + PreviewWidth;
            if(nextWidth > maxWidth){
                nextWidth = maxWidth;
            }
            images.animate({
                scrollLeft:nextWidth+'px'
            },500)
        })

        //Voltar

        $('.imageField .left').click(function(){
            let images = $(this).parent().parent().find('.images')
            let actWidth =  images.scrollLeft();;
            let nextWidth = actWidth - PreviewWidth;
            if(nextWidth < 0){
                nextWidth = 0;
            }
            images.animate({
                scrollLeft:nextWidth+'px'
            },500)
        })
    
    

    //Contador de caracteres textarea

        function getCaracCounter(){
            let value = $('.textareaField textarea').val().length
            $('.textareaField').find('span p').html(value)
        }
        let textarea = $('.textareaField textarea');
        if(textarea.html() != undefined){
            getCaracCounter();
        }

    $('.textareaField textarea').keyup(function(){
        let value = $(this).val().length
        $('.textareaField').find('span p').html(value)

        if(value >= 255){
            $('.caracCounter').css('color','red')
        }else{
            $('.caracCounter').css('color','#ccc')
        }
    })


    //DELETAR AMiZADE
    $('.deleteFriend').click(function(){
        if(confirm('Desfazer amizade?')){
            //Deletar
            let id = $(this).parent().attr('idFriend');
            let container = $(this).parent();
            $.ajax({
                url:path+'ajax/requests.php',
                method:"post",
                data:{idfriend:id,action1:'deletefriend'}
            }).done(function(){
                container.fadeOut(function(){
                    container.remove();
                })
            })
        }
    })

    //MOSTRAR MENU DE OPÇÕES
    $('.postSingle').hover(function(){
        //Checar se tem o menu
        let menu = $(this).find('.openOptions');
        if(typeof(menu) != undefined){
            //menu existe
            menu.fadeIn(200)
        }
    },function(){
        let menu = $(this).find('.openOptions');
        if(!menu.parent().find('.options').is(':visible')){
            if(typeof(menu) != undefined){
                //menu existe
                menu.fadeOut(200)
            }
        }
    })

    //ABRIR MENU DE OPÇÔES
    $('.openOptions').click(function(){
        let menu = $(this).parent().find('.options')
        menu.slideToggle(200);
        
    })

    //DELETAR POST
    $('.deletePost').click(function(){
        let container = $(this).parents('.postSingle');
        let postId = container.find('.actionBtn').attr('idPost');
        if(confirm('Deletar Post?')){
            $.ajax({
                url:path+'ajax/requests.php',
                method:'post',
                data:{action1:'deletePost',idPost:postId}
            }).done(function(){
                container.fadeOut(function(){
                    container.remove();
                })
            })
        }
    })
    
    //Buscar amigos
    $('.searchForm input').keyup(function(){
        
            let val = $(this).val();
            $.ajax({
                url:path+'ajax/requests.php',
                method:'post',
                data:{action1:'searchFriend',user:val},
                dataType:'json'
            }).done(function(data){
                $('.amigos').html('');
                Object.keys(data).forEach(function(key) {
                    
                    //data[key].user
                    $('.amigos').append(`
                    <div class="amigoSingle add flex" idUser="${data[key].id}">
                    <div class="img"></div>
                    <div class="flex">
                        <div class="info">
                            <p><a href="${path+'home/perfil/'+data[key].user}">${data[key].user}</a></p>
                            <span>Cidade</span>
                        </div>
                        
                    </div>    
                    </div><!--amigoSingle-->
                    `);
                    if(data[key].img != ''){
                        $('.amigoSingle').eq(key).find('.img').append(`<img src="${path}'uploads/'${data[key].img} alt="">`)
                    }else{
                        $('.amigoSingle').eq(key).find('.img').append(`<img src="${path}'assets/avatar-placeholder.jpg alt="">`)
                    }
                    if(data[key].solicitacao){
                        $('.amigoSingle').eq(key).find('.flex').append(`<button disabled class="addFriend"><i class="fa-solid fa-check"></i></button>`)
                    }else{
                        $('.amigoSingle').eq(key).find('.flex').append(`<button class="addFriend"><i class="fa-solid fa-plus"></i></button>`)
                    }
                    
                  
                  });
            })
    })

    //Habilitar overlay Fixo
    /*if(typeof($('.autenticateBox')) != undefined){
        $('.overlayFix').show();
    }*/

    //Checar código de autenticação de e-mail
    $('.authCode').keyup(function(){
        let val = $(this).val();
        let container = $(this).parent();
        if(val.length == 6){
            $.ajax({
                url:path+'ajax/requests.php',
                method:'post',
                data:{action1:'checkCode',code:val}
            }).done(function(data){
                if(data == 'true'){
                    //Código Cérto
                    container.find('small').css('color','green'); 
                    container.find('small').html(`*Código Válido`)
                    setTimeout(() => {
                        $.ajax({
                            url:path+'ajax/requests.php',
                            method:'post',
                            data:{'action1':'createAccount'}
                        }).done(function(){
                            container.parent().fadeOut();
                            $('.overlayFix').hide();
                            window.location.href=path;
                        })

                        
                        
                    }, 2000);
                }else{
                    //Código Errado
                    container.find('small').css('color','red'); 
                    container.find('small').html(`*Código Inválido`)
                }
            })
        }else{
            container.find('small').html(``)
        }
    })

    //Comentar Comentário - (Abrir formulario)
    $('body').on('click','.reply',function(){
        let container = $(this).parent().parent();
        let ownerId = $(this).parent().attr('ownerId');

        //validação de container
        if(container.find('.replyComment').html() == undefined){
            $('.replyComment').remove()
            container.append(`
            <form method="post" class="flex commentForm replyComment">
                <textarea name="comentario" placeholder="Seu comentário..."></textarea>
                <input type="submit" name="postComment" id="submitReply" style="display:none;">
                <input type="hidden" name="ownerId" value="${ownerId}">
                <label for="submitReply"><i class="fa-solid fa-paper-plane"></i></label>
            </form>
            `);
        }else{
            container.find('.replyComment').remove();
        }
    })

    //Comentar comentario - (Adicionar comentario)
    $('body').on('submit','.replyComment',function(e){
        let commentId = $(this).parent().find('.commentActions').attr('idComment');
        let content = $(this).find('textarea').val();
        let ownerId = $(this).find('[name=ownerId]').val();
        let quantityContainer = $(this).parent().find('.quantity');
        let quantity = parseInt(quantityContainer.html()) + 1;
        let container = $(this);
        let repliedName = container.parent().find('.commentInfo p').html();
        e.preventDefault();
        $.ajax({
            url:path+'ajax/requests.php',
            method:'post',
            data:{action1:'addReply',commentId:commentId,content:content,repliedName:repliedName,ownerId:ownerId}
        }).done(function(){
            quantityContainer.html(quantity)
            container.remove()
        })
    })

    //Comentar comentario - (mostrar respostas)

    $('.show').click(function(){
        let container = $(this).parent().parent();
        if(container.find('.replys').html() == undefined){
            container.find('.status').html('Ocultar');
            container.append(`<div class="replys"></div>`)

            let commentId = container.find('.commentActions').attr('idComment');
            $.ajax({
                url:path+'ajax/requests.php',
                method:'post',
                dataType:'json',
                data:{action1:'getReplys',commentId:commentId}
            }).done(function(replys){
                Object.keys(replys).forEach(key => {
                    //<img src="<?=PATH.'uploads/'.$userInfoComment['img']?>">
                    $.ajax({
                        url:path+'ajax/requests.php',
                        method:'post',
                        dataType:'json',
                        data:{action1:'getUserInfo',userId:replys[key].id_user}
                    }).done(function(user){
                        console.log(user)
                        $('.replys').prepend(`
                        <div class="commentSingle" style="margin-left:55px;">
                            <div class="flex">
                                <div class="commentImg">  
                                </div>
                                <div class="commentInfo">
                                    <p><a href="${path}home/perfil/${user[0].user}">${user[0].user}</a></p>
                                    <span>${replys[key].content}</span>
                                </div>
                            </div><!-- flex -->    
                        </div><!--comentSingle-->
                        `)

                        if(user[0].img == ''){
                            $('.replys').find('.commentSingle').eq(0).find('.commentImg').html('<img src="'+path+'assets/avatar-placeholder.jpg">')
                        }else{
                            $('.replys').find('.commentSingle').eq(0).find('.commentImg').html('<img src="'+path+'uploads/'+user[0].img+'">')
                        }
                    })                         
                });
            })
        }else{
            container.find('.status').html('Mostrar');
            container.find('.replys').remove()
        }
    })
        
})

