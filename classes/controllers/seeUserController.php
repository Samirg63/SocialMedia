<?php
    namespace controllers;
    class seeUserController{
        public function index(){
            \views\mainview::render('seeUser',['css'=>['seeUser','userInfo'],'component'=>['carrossel']]);
        }
    }
?>