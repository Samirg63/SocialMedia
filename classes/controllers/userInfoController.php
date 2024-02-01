<?php
    namespace controllers;

    class userInfoController{

        public function index(){
            \views\mainview::pureRender('userInfo',['css'=>['userInfo']]);
        }
    }
?>