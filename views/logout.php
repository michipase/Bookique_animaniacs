<?php
    require_once __DIR__."/../utils/config.php";


    try {
        unset($_COOKIE['user']); 
        unset($_SESSION['user']);

        header('location: landing');
    } catch (\Throwable $th) {
        header('location: landing');
    }
  
?>
