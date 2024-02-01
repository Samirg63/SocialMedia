<?php
    namespace controllers;

    class erroController{

        public function index(){
            \views\mainview::render('erro',['css'=>'erro']);
        }
    }
?>