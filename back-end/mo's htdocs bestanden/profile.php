<?php

session_start();
require_once("conn.php");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
if (!isset($_SESSION['loggedin'])) {
    header("Location: index.html");
}

$query = ('SELECT password, username FROM user WHERE id = ?');
$stmt = $con->prepare($query);


$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $username);
$stmt->fetch();
$stmt->close();


?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>

<div class="content">
			<h2>Profile Page</h2>
			<div>
				<p>Your account details are below:</p>
				<table>
					<tr>
						<td>Username:</td>
						<td><?=$_SESSION['name']?></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><?=$password?></td>
					</tr>
					
                   
				</table>
			</div>
		</div>
	</body>

</html>
    
</body>
</html>