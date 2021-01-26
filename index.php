<?php

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/' :
        require __DIR__ . '/views/home.php';
        break;
    case '/about' :
        require __DIR__ . '/views/about.php';
        break;
    case '/login' :
        require __DIR__ . '/views/login.php';
        break;
    case '/signup':
        require __DIR__ . '/views/signup.php';
        break;

    // add here new routes
    
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}
?>