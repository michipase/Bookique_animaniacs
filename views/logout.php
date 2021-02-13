<?php
    require_once __DIR__."/../utils/config.php";


    if(isset($_COOKIE['user'])){
        setcookie('user', '');
        header('location: landing');
    }
  
?>
