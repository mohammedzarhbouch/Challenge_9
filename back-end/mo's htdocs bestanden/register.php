<?php
require_once "conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $repeatPassword = $_POST["Repeat-Password"];

    if ($password !== $repeatPassword) {
        echo "Passwords don't match. Please try again.";
    } else {
        // Prepare and bind the SQL statement
        $stmt = $con->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);

        // Execute the SQL statement
        if ($stmt->execute() === TRUE) {
            header("Location: index.html");
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
}

// Close the connection
$con->close();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.3.0/css/all.css">
		
	</head>
	<body>
		<div class="login">
			<h1>Register</h1>
			<form id="register-form" action="register.php" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>

				<label for="repeat-password">
					<i class="fas fa-repeat"></i>
				</label>
				<input type="Repeat-Password" name="Repeat-Password" placeholder="Repeat-Password" id="Repeat-Password" required>
				<input type="submit" value="Register">
				
			</form>
		</div>
	</body>
</html>
