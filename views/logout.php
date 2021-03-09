<?php
// Include config file
$titolo = 'Bookique - Logout';
require_once UTILS_DIR . 'config.php';
include ASSETS_DIR . 'asset.php';


    if(isset($_COOKIE['user'])){
        setcookie('user', '');
        header('location: landing');
    }
  
?>
