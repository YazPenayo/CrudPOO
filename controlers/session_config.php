<?php

if (session_status() === PHP_SESSION_NONE) {
    
    ini_set('session.cookie_lifetime', 86400); 
    ini_set('session.gc_maxlifetime', 86400);  

    
    session_start();

    
    $cookie_duration = 30 * 24 * 60 * 60; 

    if (!isset($_SESSION['initiated'])) {
        session_regenerate_id();
        $_SESSION['initiated'] = true;

        setcookie('remember_me', session_id(), time() + $cookie_duration, "/");
    }

    if (isset($_COOKIE['remember_me']) && session_id() !== $_COOKIE['remember_me']) {
        session_write_close();
        session_id($_COOKIE['remember_me']);
        session_start();
    }
}