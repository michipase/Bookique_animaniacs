<?php

    function OpenCon()
    {
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $db = "bookique";


        $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

        echo $conn;

        return $conn;
    }

    function CloseCon($conn)
    {
        $conn -> close();
    }

?>