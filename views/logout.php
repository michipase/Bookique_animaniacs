<?php
    require_once __DIR__."/../utils/config.php";


    if($_COOKIE['user'] && $_SESSION['user']) {

        unset($_COOKIE['user']); 
        unset($_SESSION['user']);

        header('location: landing');
    } 
  
?>
