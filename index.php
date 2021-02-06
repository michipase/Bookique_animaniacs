<?php

$request = $_SERVER['REQUEST_URI'];
$request = str_replace('Bookique_animaniacs/', '', $request);



switch ($request) {
    case '/' :
        require __DIR__ . '/views/index.php';
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

    
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="views/style.css">
</head>
<body>
    
</body>
</html>
