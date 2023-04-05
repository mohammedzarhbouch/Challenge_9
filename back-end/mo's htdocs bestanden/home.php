<?php

session_start();
require_once('conn.php');

if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}


if(isset($_SESSION['id'])) {
    // Get the user's balance from the database
    $user_id = $_SESSION['id'];
    $select_query = "SELECT balance FROM geld WHERE id = '$user_id'";
    $result = $con->query($select_query);

    if ($result === false) {
        die("Invalid query: " . mysqli_error($con));
    }

    $row = $result->fetch_assoc();
    $balance = $row['balance'];

    // Get the total price of all expenses for the currently logged-in user
    $user_id = $_SESSION['id'];
    $sql = "SELECT prijs FROM soort_uitgave WHERE user_id = '$user_id'";
    $result = $con->query($sql);

    if ($result === false) {
        die("Invalid query: " . mysqli_error($con));
    }

    $total_price = 0;
    while ($row = $result->fetch_assoc()) {
        $total_price += $row["prijs"];
    }

    // Calculate the new balance
    $new_balance = $balance - $total_price;

    // Set the session variables
    $_SESSION['new_balance'] = $new_balance;
    $_SESSION['balance'] = $balance;



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
        <a class="title">HomePage | €<?php echo $new_balance; ?></a>
        <div class="info-box">Welcome back, <?=$_SESSION['name']?>!</div>
        <div class="info-box">This is your remaining balance after your transactions: €<?php echo $new_balance; ?></div>
        <div class="info-box">test</div>
        <a href="edit_page.php" class="button">Edit Page</a>
        <a href="logout.php" class="button">logout</a>
        <a href="profile.php" class="button">profile</a>
    </div>
</body>
</html>
