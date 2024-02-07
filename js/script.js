$(function(){

    /* Geral */
    const path = $('path').attr('path');
    const userId = $('user').attr('userId');
    var deletes = [];

    function cleanPreUploads(){
        $.ajax({
            method:'post',
            url:'../ajax/destroy.php'
        })
    }
    
    //Fechar popUps
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
        deletes = [];
    })

    $('.deleteEditor').click(function(){
        $('.overlayFix').remove()
        $('.editor').remove();
    })

    //Clear Forms
    $('.editFotoForm .cancel').click(function(e){
        $('.clearForm').trigger('submit');
        e.preventDefault();
    })


    /*Página erro */
    /* fim da Página erro */
    
    /*Página feed */
    /* fim da Página feed */

    /*Página forgotPasswprd */
    /* fim da Página forgotPasswprd */

    /*Página friends */
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

    /* fim da Página friends */

    /*Página home */

        /*Formulario de newPost*/

            //Mostrar preview no fomulario de novo post
            $('body').on('change', '.imageField #images',function(e){
                if(e.target.files[0]){
                    if($('.newPost').find('[name=acao]').attr('value') != 'seePreview'){
                        $('.newPost').find('[name=acao]').attr('value','seePreview')
                        $('.newPost').trigger('submit');
                    }
                }
            })

            //Abrir formulario pra ver o preview
            if($('.newPost').find('[name=acao]').attr('value') == 'seePreview' ){
                $('.overlay').show();
                $('.newPost').show();
            }

            //Mostrar botão de remover (no preview)
            $('body').on('mouseover','.imageField .image, .postSingle .image', function(){
                $(this).find('.remove').show();
            })

            $('body').on('mouseout','.imageField .image, .postSingle .image', function(){
                $(this).find('.remove').hide();
            })

            //Remover imagem (no preview)
            $('body').on('click','.imageField .remove',function(){
                let imageName = $(this).parent().find('img').attr('src');
                let container = $(this);
                $.ajax({
                    url:path+'ajax/requests.php',
                    method:'post',
                    data:{action1:'removeFromImages',img:imageName}
                }).done(function(){
        
                    container.parent().remove();
                    
                    
                    if($('.imageField').find('.image').length == 1){
                        $('.imageField').find('.carrosselBtn').remove();
                    }else if($('.imageField').find('.image').length == 0){
                        $('.imageField').html(`
                        <input type="hidden" name="acao" value="acaoNoPhoto">
                        <label for="images"><i class="fa-regular fa-images"></i></label>
                        <h5>Adicione imagens</h5>
                        <input id="images" type="file" name="fotos[]" style="display:none;" multiple="multiple">`)
                        $('.lock').remove();
                    }
                })
        
                
                
            })
            
            //Bloquear formulario durante preview
            $('.newPost').on('submit',function(){
                if(typeof($('.newPost').find('.lock').html()) != 'undefined'){
                    return false;
                }  
            })

            //Enviar formulario
            $('.createPost').click(function(){
                $('.lock').remove();
                $('.newPost').find('[name=acao]').attr('value','postPhoto')
                $('.newPost').submit();
            })
            
            //Abrir Formulario
            $('.openPost').click(function(){
                fecharPopUp();
                $('.overlay').show();
                $('.newPost').show();
        
                return false;
            })


        /*Fim formulario newPost*/

        //Abrir Notificações         
        $('.openNotification').click(function(){
            document.title = "Social Media";
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

        //fechar notificações
        $('.closeNotification').click(function(){
            $('.full').show();
            $('.resumido').hide();
            $('.notifications').hide();
        })

        //Confirmar notificação de amizade
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

        //Rejeitar notificação de amizade
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



    /* fim da Página home */

    /*Página login*/

        //Checar código de autenticação de e-mail (criaçaõ da conta)
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
    /* fim da Página login*/

    /*Página perfil*/

            /*Fomulario Edit Perfil*/

                //Submit
                $('.editPerfilSubmit').click(function(){
                    $('.editPerfilForm').submit();
                })

                //Abrir Formulario
                $('.editPerfil').click(function(){
                    $('.overlay').fadeIn();
                    $('.editPerfilForm').fadeIn();
                })

            /*Fim Fomulario Edit Perfil*/

            /*Fomulario Edit Foto*/

                //submit
                $('.editFotoSubmit').click(function(){
                    $('.editFotoForm').submit();
                })

                //Mostrar opção de mudar de foto
                $('.imgPerfil').hover(function(){
                    $('.editFoto').show();
                    $(this).find('img').animate({opacity:0.4},500)
                },function(){
                    $('.editFoto').hide();
                    $(this).find('img').animate({opacity:1},500)
                })

                //Abrir formualrio
                $('.imgPerfil').click(function(){
                    fecharPopUp();
                    $('.overlay').fadeIn();
                    $('.editFotoForm').fadeIn();
                })

                //Abrir formulario pra ver o preview
                if($('openpreview').attr('open')){
                    $('.overlay').fadeIn();
                    $('.editFotoForm').fadeIn();
                    $('.fields').hide();
                    $('.imgPreview').css('display','flex');
            
                    let img = $('preview').attr('img');
                    $('.preview img').attr('src',path+'preUploads/'+userId+'/'+img)
                }
               
               //Mostrar preview
                $('#fotoInput').change(function(){
                $('.editFotoForm').trigger('submit')
                })

                //Confirmar edição de foto
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


            /*Fim Fomulario Edit Foto*/

            //Contador de caracteres para a bio

            function getCaracCounter(){
                let value = $('.textareaField textarea').val().length
                $('.textareaField').find('span p').html(value)
            }

            let textarea = $('.textareaField textarea');

            //puxar caracteres ja existentes
            if(textarea.html() != undefined){
                getCaracCounter();
            }

            //adicionar/remover da contagem
            $('.textareaField textarea').keyup(function(){
                let value = $(this).val().length
                $('.textareaField').find('span p').html(value)

                if(value >= 255){
                    $('.caracCounter').css('color','red')
                }else{
                    $('.caracCounter').css('color','#ccc')
                }
            })

    /* fim da Página perfil*/

    /*Página seeUser */
    /* fim da Página seeUser */

    /*Página userInfo */
    /* fim da Página userInfo */

    /*Component PostSingle*/
        
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
            console.log(info)
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
                
                
                if(data[0].img != ''){
                    var image = path+'uploads/'+data[0].img
                }else{
                    var image = path+'assets/avatar-placeholder.jpg'
                }

                container.prepend(`
                <div class="commentSingle">
                <button class="openOptionsComment"><i class="fa-solid fa-ellipsis"></i></button>
                <div class="optionsComment">
                    <ul>
                        <li><button class="deleteComment"><i class="fa-regular fa-trash-can"></i><span>Apagar comentario</span></button></li>
                        <li><button class="editComment"><a href="${path}home/editComment=${data[1]}">
                            <i class="fa-solid fa-pen"></i><span>Editar comentario</span></button></li>
                        </a>
                    </ul>
                </div>
                <div class="flex">
                    <div class="commentImg">
                        <img src="${image}">
                    </div>
                    <div class="commentInfo">
                        <p>${data[0].user}</p>
                        <span>${content}</span>
                    </div>
                </div>
                <div class="actionBtn flex commentActions" idComment="${data[1]}" ownerId="${ownerId}">
                    <button class="like-comment" "><i  class="fa-regular fa-heart"></i><span>0</span></button>
                    <button class="reply" ><i class="fa-solid fa-reply"></i></button>
                    <button class="show"><span class="status">Mostrar</span> Resposta (<span class="quantity">0</span>)</button>
                </div><!--actionBtn-->  
                
                </div><!--comentSingle-->
                `)
            })
            
        })

        //Editar Post
        $('.editPostSubmit').click(function(){
            let conteudo = $('.float').find('[name=conteudo]').val();
            let imgString = '';
            let postId = $('[name=postId]').val();
            let first = true;
            for (let i = 0; i < $('.float .image').length; i++) {
                let img = $('.float .image').eq(i).find('img').attr('src')
                img = img.split('/')
                let position = img.length - 1
                if(first){
                    imgString += img[position]
                    first = false;
                }else{
                    imgString += '<-!->'
                    imgString += img[position]
                }
                
            }
            
            $.ajax({
                url:path+'ajax/requests.php',
                method:'post',
                data:{action1:'editPost',conteudo:conteudo,img:imgString,deletes:deletes,postId:postId}
            }).done(function(){
                console.log(deletes);
                if($('[name=page]').val() == 'perfil'){
                    window.location.href=path+'home/perfil';
                }else{
                    window.location.href=path+'home';
                }
            })
        })

        //Remover imagem do post
        
        $('body').on('click','.postSingle .remove',function(){
            let image = $(this).parent().find('img').attr('src')
            image = image.split('/')
            let position = image.length - 1
            deletes.push(image[position]);
            $(this).parent().remove();
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

            //Sessão comentarios

            //Comentar Comentário - (Abrir formulario)
            $('body').on('click','.reply',function(){
                let container = $(this).parent().parent();
                let ownerId = $(this).parent().attr('reply_to');

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
                let quantityContainer = $(this).parents('.commentSingle').find('.quantity');
                let quantity = parseInt(quantityContainer.html()) + 1;
                let container = $(this);
                e.preventDefault();
                $.ajax({
                    url:path+'ajax/requests.php',
                    method:'post',
                    data:{action1:'addReply',commentId:commentId,content:content,ownerId:ownerId}
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
                                $('.replys').prepend(`
                                <div class="commentSingle" style="margin-left:55px;">
                                    <div class="flex">
                                        <div class="commentImg">  
                                        </div>
                                        <div class="commentInfo">
                                            <p><a href="${path}home/perfil/${user[0].user}">${user[0].user}</a></p>
                                            <span><b>@${replys[key].prefix}</b> ${replys[key].content}</span>
                                        </div>
                                    </div><!-- flex -->    
                                        <div class="actionBtn flex commentActions" idComment="${replys[key].id_comment}" reply_to="${replys[key].id_user}">
                                        <button class="reply reply-comment">
                                            <i class="fa-solid fa-reply"></i>
                                        </button>
                                        </div><!--actionBtn-->
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

            //Menu de opções dos commentarios
             //MOSTRAR MENU DE OPÇÕES
            $('.commentSingle').hover(function(){
                //Checar se tem o menu
                let menu = $(this).find('.openOptionsComment');
                if(typeof(menu) != undefined){
                    //menu existe
                    menu.fadeIn(200)
                }
            },function(){
                let menu = $(this).find('.openOptionsComment');
                if(!menu.parent().find('.optionsComment').is(':visible')){
                    if(typeof(menu) != undefined){
                        //menu existe
                        menu.fadeOut(200)
                    }
                }
            })

            //ABRIR MENU DE OPÇÔES
            $('.openOptionsComment').click(function(){
                let menu = $(this).parent().find('.optionsComment')
                menu.slideToggle(200);
                
            })

            //Deletar comentário

            $('.deleteComment').click(function(){
                let container = $(this).parents('.commentSingle');
                let commentId = container.find('.actionBtn').attr('idComment');
                let idPost = container.find('.actionBtn').attr('id_post');
                let commentQuant = $(this).parents('.postSingle').find('.comment').attr('noFormatedNumber');
                if(confirm('Deletar Comentario?')){
                    $.ajax({
                        url:path+'ajax/requests.php',
                        method:'post',
                        data:{action1:'deleteComment',idComment:commentId, idPost:idPost,commentQuant:commentQuant}
                    }).done(function(){
                        container.fadeOut(function(){
                            container.remove();
                        })
                    })
                }
            })

            //editarComentario

            $('.editCommentSubmit').click(function(){
                let conteudo = $('.float').find('[name=commentContent]').val();
                let commentId = $('[name=commentId]').val();
                
                
                
                $.ajax({
                    url:path+'ajax/requests.php',
                    method:'post',
                    data:{action1:'editComment',conteudo:conteudo,commentId:commentId}
                }).done(function(){
                    if($('[name=page]').val() == 'perfil'){
                        window.location.href=path+'home/perfil';
                    }else{
                        window.location.href=path+'home';
                    }
                })
            })
    


            
    /*Component passWordBox*/

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

    /*Component Carrossel*/
        //HABILITAR CARROSEL
            $('div.carrosel').parent().append(`
            <div class="carrosselBtn flex">
                <button class="left" style="opacity:0;"><i class="fa-solid fa-arrow-left"></i></button>
                <button class="right"><i class="fa-solid fa-arrow-right"></i></button>
            </div>
            `);
        
            $('div.carroselPerfil').parent().append(`
            <div class="carrosselBtn flex">
                <button class="left" style="opacity:0;"><i class="fa-solid fa-arrow-left"></i></button>
                <button class="right"><i class="fa-solid fa-arrow-right"></i></button>
            </div>
            `);

        //Configurações do carrossel
            var postWidth = $('.postSingle').width()
            var perfilWidth = $('.user').width();
            var PreviewWidth = $('.images').width();


        //Funcionalidade
           
            //Avançar
            $('.postSingle .right').click(function(){
                let images = $(this).parent().parent().find('.images')
                let actWidth =  images.scrollLeft();
                let imagesQuant = 2;
                let imageWidth = images.find('.image').width();
                let scrool = imageWidth * imagesQuant;
                var maxScroll = images[0].scrollWidth - images.outerWidth();
                let nextWidth = actWidth + scrool;
                if(nextWidth >= maxScroll){
                    nextWidth = maxScroll
                }
                images.animate({
                    scrollLeft:nextWidth+'px'
                },500)


                //desabilitar
                
                if((actWidth+scrool) >= maxScroll-20){
                    $(this).css('opacity','0');
                }

                //habilitar left
                if($(this).parent().find('.left').css('opacity') == 0){
                    $(this).parent().find('.left').css('opacity','.7')
                }
            })

            //Voltar

            $('.postSingle .left').click(function(){
                let images = $(this).parent().parent().find('.images')
                let actWidth =  images.scrollLeft();
                let imagesQuant = 2;
                let imageWidth = images.find('.image').width();
                let scrool = imageWidth * imagesQuant;
                var maxScroll = images[0].scrollWidth - images.outerWidth();
                let nextWidth = actWidth - scrool;
                if(nextWidth <= 0){
                    nextWidth = 0;
                }
                images.animate({
                    scrollLeft:nextWidth+'px'
                },500)


                //desabilitar
                
                if((actWidth - scrool) <= 0){
                    $(this).css('opacity','0')     
                }

                //habilitar right
                if($(this).parent().find('.right').css('opacity') == 0){
                    $(this).parent().find('.right').css('opacity','.7')
                }
            })
        
        //PERFIL

            //Avançar
            $('.user .right').click(function(){
                let images = $(this).parent().parent().find('.userPhotos');
                let actWidth =  images.scrollLeft();
                let imagesQuant = 5;
                let imageWidth = images.find('.photoSingle').width();
                let scrool = imageWidth * imagesQuant;
                var maxScroll = images[0].scrollWidth - images.outerWidth();
                let nextWidth = actWidth + scrool;
                if(nextWidth >= maxScroll){
                    nextWidth = maxScroll
                }
                images.animate({
                    scrollLeft:nextWidth+'px'
                },500)


                //desabilitar
                if((actWidth+scrool) >= maxScroll-20){
                    $(this).css('opacity','0');
                }

                //habilitar left
                if($(this).parent().find('.left').css('opacity') == 0){
                    $(this).parent().find('.left').css('opacity','.7')
                }
            })

            //Voltar

            $('.user .left').click(function(){
                let images = $(this).parent().parent().find('.userPhotos')
                let actWidth =  images.scrollLeft();
                let imagesQuant = 5;
                let imageWidth = images.find('.photoSingle').width();
                let scrool = imageWidth * imagesQuant;
                let nextWidth = actWidth - scrool;
                if(nextWidth <= 0){
                    nextWidth = 0;
                }
                images.animate({
                    scrollLeft:nextWidth+'px'
                },500)


                //desabilitar
                
                if((actWidth - scrool) <= 0){
                    $(this).css('opacity','0')     
                }

                //habilitar right
                if($(this).parent().find('.right').css('opacity') == 0){
                    $(this).parent().find('.right').css('opacity','.7')
                }
            })

        //PREVIEWPOST
        
            //Avançar
            $('.imageField .right').click(function(){
                let images = $(this).parent().parent().find('.images');
                let actWidth =  images.scrollLeft();
                let imagesQuant = 1;
                let imageWidth = images.find('.image').width();
                let scrool = imageWidth * imagesQuant;
                var maxScroll = images[0].scrollWidth - images.outerWidth();
                let nextWidth = actWidth + scrool;
                if(nextWidth >= maxScroll){
                    nextWidth = maxScroll
                }
                images.animate({
                    scrollLeft:nextWidth+'px'
                },500)


                //desabilitar
                if((actWidth+scrool) >= maxScroll-20){
                    $(this).css('opacity','0');
                }

                //habilitar left
                if($(this).parent().find('.left').css('opacity') == 0){
                    $(this).parent().find('.left').css('opacity','.7')
                }
            })

            //Voltar

            $('.imageField .left').click(function(){
                let images = $(this).parent().parent().find('.images')
                let actWidth =  images.scrollLeft();
                let imagesQuant = 1;
                let imageWidth = images.find('.image').width();
                let scrool = imageWidth * imagesQuant;
                let nextWidth = actWidth - scrool;
                if(nextWidth <= 0){
                    nextWidth = 0;
                }
                images.animate({
                    scrollLeft:nextWidth+'px'
                },500)


                //desabilitar
                
                if((actWidth - scrool) <= 0){
                    $(this).css('opacity','0')     
                }

                //habilitar right
                if($(this).parent().find('.right').css('opacity') == 0){
                    $(this).parent().find('.right').css('opacity','.7')
                }
            })
    })