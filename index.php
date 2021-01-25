<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="/Bookique_animaniacs/">Home</a>
            <a class="nav-item nav-link" href="/Bookique_animaniacs/about">About</a>
            <a class="nav-item nav-link" href="/Bookique_animaniacs/login">login</a>
            <a class="nav-item nav-link" href="/Bookique_animaniacs/registration">registration</a>
        </div>
    </nav>

    <?php

    require 'db.php';

    $request = $_SERVER['REQUEST_URI'];


    try {
        $request = str_replace('/Bookique_animaniacs', '', $request);
    } catch (\Throwable $th) {

    }


    
    switch ($request) {
        case '/' :
            require __DIR__ . '/views/index.php';
            break;
        case '/about' :
            require __DIR__ . '/views/about.php';
            break;
        case '/registration':
            require __DIR__ . '/views/registration.php';
            break;
        case '/login' :
            require __DIR__ . '/views/login.php';
            break;

        default:
            http_response_code(404);
            require __DIR__ . '/404.php';
            break;
    }
?>
</body>
</html>