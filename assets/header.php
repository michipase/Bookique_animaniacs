<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">
    <link href="../css/site.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Dancing+Script">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <title><?php echo $titolo ?></title>
</head>
<body>
<nav>
    <ul class="container">
        <li><a href='<?php echo "/";?>'>Home</a></li>
        <li class='dropdown'>
            <a href='<?php echo "/about";?>'>About <i class="fa fa-angle-down"></i></a>
        </li><!-- /.dropdown -->
        <li class='dropdown'>
            <a href='upload'>Books <i class="fa fa-angle-down"></i> </a>

        </li><!-- .dropdown -->
        <li><a href='<?php echo "/login";?>'>Login</a></li>
    </ul><!-- .container -->
</nav>
