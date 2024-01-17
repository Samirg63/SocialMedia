<?php
    $dir = scandir(BASE_DIR.'/preUploads/'.$_SESSION['id']);
    foreach ($dir as $key => $value) {
        if($value == '.' || $value == ".."){
            continue;
        }
        @unlink(BASE_DIR.'/preUploads/'.$_SESSION['id'].'/'.$value);
    }
    @rmdir(BASE_DIR.'/preUploads/'.$_SESSION['id']);
    die();
?>