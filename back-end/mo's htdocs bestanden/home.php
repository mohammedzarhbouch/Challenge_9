<?php

session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}


$balance = isset($_SESSION['balance']) ? $_SESSION['balance'] : '';
$new_balance = isset($_SESSION['new_balance']) ? $_SESSION['new_balance'] : '';
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
        <a class="title">HomePage | €<?php echo $new_balance; ?></a>
        <div class="info-box">Welcome back, <?=$_SESSION['name']?>!</div>
        <div class="info-box">This is your remaining balance after your transactions: €<?php echo $new_balance; ?></div>
        <div class="info-box">test</div>
        <a href="edit_page.php" class="button">Edit Page</a>
        <a href="logout.php" class="button">logout</a>
    </div>
</body>
</html>
