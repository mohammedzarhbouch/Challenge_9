<?php
require_once "conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $repeatPassword = $_POST["Repeat-Password"];
    $initial_balance = 1;

    if ($password !== $repeatPassword) {
        echo "Passwords don't match. Please try again.";
    } else {
        // Prepare and bind the SQL statement to insert the user information
        $stmt = $con->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);

        // Insert initial balance for the new user
        $stmt->execute();
        $user_id = $stmt->insert_id; // Get the ID of the newly inserted user

        // Prepare and bind the SQL statement to insert the initial balance for the new user
        $stmt = $con->prepare("INSERT INTO geld (user_id, balance) VALUES (?, ?)");
        $stmt->bind_param("id", $user_id, $initial_balance);
        $stmt->execute();

        // Check if the SQL statements were executed successfully
        if ($stmt->affected_rows > 0) {
            header("Location: index.html");
        } else {
            echo "Error: Failed to create account. Please try again.";
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
		<link rel="stylesheet" href="style.css">
		
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
