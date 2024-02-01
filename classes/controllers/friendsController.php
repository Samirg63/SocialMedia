<?php
    namespace controllers;

    class friendsController{

        public function index(){
            \views\mainview::pureRender('friends',['page'=>'amigos','css'=>['friends']]);
        }

        public function index2(){
            \views\mainview::pureRender('friends',['page'=>'addAmigos','css'=>['friends']]);
        }
    }
?>