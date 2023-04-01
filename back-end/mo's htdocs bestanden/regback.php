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
        $stmt = $conn->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
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
$conn->close();
?>
