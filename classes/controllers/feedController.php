<?php
    namespace controllers;

    class feedController{

        public function index(){
            

            \views\mainview::pureRender('feed',['css'=>['feed'],'component'=>['postSingle','carrossel']]);
        }
    }
?>