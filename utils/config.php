<?php

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

    /**
     * @param x - requires and array of authenticated roles. ex [0,1] -> 0 = admin, 1 = editor. 2(reader) i not allowed
     */
    function requiresAuth($x = []) {

        $ut_type = unserialize(base64_decode($_COOKIE['user']))['data']['ut_type'];

        if(!empty($x) && !in_array($ut_type, $x, true)){
            header('location: 401');
            echo 'not allowed';
        }
    }
?>