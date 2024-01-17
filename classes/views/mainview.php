<?php
    namespace views;

    class mainview{
        public static function render($fileName, $arr = [],$header = 'header',$footer = 'footer'){
            include('pages/includes/'.$header.'.php');
            include('pages/'.$fileName.'.php');
            include('pages/includes/'.$footer.'.php');
        }

        public static function pureRender($fileName, $arr = []){
            include('pages/'.$fileName.'.php');
        }
    }
?>