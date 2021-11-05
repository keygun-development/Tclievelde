<?php
    if(isset($_COOKIE['user'])) {
        unset($_COOKIE['user']);
        setcookie('user', '', time() - (86400 * 30), '/');
        header('location: /');
    } else {
        header('location: /inloggen');
    } 
?>