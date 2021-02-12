<?php
    /* Database credentials. Assuming you are running MySQL
    server with default setting (user 'root' with no password) */
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'auth_bookique');
    
    /* Attempt to connect to MySQL database */
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    // Check connection
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    function requiresAuth($x = []) {
        $ut_type = unserialize(base64_decode($_COOKIE['user']['data']['ut_type']));
        print_r($ut_type);

        if(!empty($x) && !in_array($ut_type, $x, true)){
            header('location: login');
        }
    }
?>