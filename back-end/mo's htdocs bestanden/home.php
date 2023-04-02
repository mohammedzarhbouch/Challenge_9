<?php

session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <title>Document</title>
    
</head>
<body class="loggedin">
    <div class="container">
        <a class="title">HomePage</a>
        <div class="info-box">welkom terug, <?=$_SESSION['name']?>!</div>
        <div class="info-box">test</div>
        <div class="info-box">test</div>
        <a href="edit_page.php" class="button">Edit Page</a>
        <a href="logout.php" class="button">logout</a>

    </div>
</body>
</html>