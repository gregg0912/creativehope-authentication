<?php
    session_start();

    if(session_destroy()) {
        $root = $_SERVER['HTTP_HOST'];
        setcookie("user_login", NULL, time()-3600, "/", $root);

        $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/creativehope-authentication\/';
        header("Location: {$root}");
    }
?>