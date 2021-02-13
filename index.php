<?php
session_start();

$request = $_SERVER['REQUEST_URI'];
$request = str_replace('Bookique_animaniacs/', '', $request);

switch ($request) {
    case '/' :
        require './views/landing.php';
        break;

    case '/about' :
        require './views/about.php';
        break;

    case '/login' :
        require './views/login.php';
        break;
    
    case '/signup':
        require './views/signup.php';
        break;

    case '/logout':
        require './views/logout.php';
        break;

    case '/landing' :
        require './views/landing.php';
        break;

    case '/home' :
        require './views/home.php';
        break;
    
    case '/401' :
        require './views/401.php';
        break;

    
    default:
        http_response_code(404);
        require './views/404.php';
        break;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>main</title>

    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
</body>
</html>
