<?php




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $repeatPassword = $_POST["Repeat-Password"];

    if ($password !== $repeatPassword) {
        echo "Passwords don't match. Please try again.";
    } else {
        // Code to save the data to the database
        $servername = "localhost";
        $db_username = "root";
        $db_password = "";
        $dbname = "challenge9";

        // Create connection
        $conn = new mysqli($servername, $db_username, $db_password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind the SQL statement
        $stmt = $conn->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);

        // Execute the SQL statement
        if ($stmt->execute() === TRUE) {
            header("Location: index.html");
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the connection
        $stmt->close();
        $conn->close();
    }
}
?>
