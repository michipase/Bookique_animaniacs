<?php
session_start();

$request = $_SERVER['REQUEST_URI'];
$request = str_replace('Bookique_animaniacs/', '', $request);

define('MAIN_DIR', dirname(__FILE__) . '/');
define('UTILS_DIR', MAIN_DIR . 'utils/');
define('ASSETS_DIR', MAIN_DIR . 'assets/');
define('VIEWS_DIR', MAIN_DIR . 'views/');


switch ($request) {
    case '/' :
        require VIEWS_DIR . 'landing.php';
        break;

    case '/about' :
        require VIEWS_DIR . 'about.php';
        break;

    case '/login' :
        require VIEWS_DIR . 'login.php';
        break;
    
    case '/signup':
        require VIEWS_DIR . 'signup.php';
        break;

    case '/logout':
        require VIEWS_DIR . 'logout.php';
        break;

    case '/landing' :
        require VIEWS_DIR . 'landing.php';
        break;

    case '/home' :
        require VIEWS_DIR . 'home.php';
        break;
    
    case '/401' :
        require VIEWS_DIR . '401.php';
        break;

    case '/upload' :
        require VIEWS_DIR . 'upload.php';
        break;
    
    default:
        http_response_code(404);
        require VIEWS_DIR . '404.php';
        break;
}
?>