<?php
    session_start();

    if(!isset($_SESSION['user'])){ //https://codeshack.io/secure-login-system-php-mysql/ <- most of the way down the page
        header("Location: ../login");
        exit;
    }
?>