<?php
session_start();


include('conn.php');

$error_message = "";



// Insert a new expense into the database
if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $user_id = $_SESSION['id']; // get the currently logged-in user's ID

    if(empty($name) || empty($description) || empty($price)) {
        $error_message = "Please fill out all required fields";
    } else {
        $sql = "INSERT INTO soort_uitgave (naam, info, prijs, user_id) VALUES ('$name', '$description', '$price', '$user_id')";

        if ($con->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
    }
}

// Update the user's balance
if(isset($_POST['balance'])) {
    $new_balance = $_POST['balance'];
    $user_id = $_SESSION['id']; // get the currently logged-in user's ID
    $update_query = "UPDATE geld SET balance = '$new_balance' WHERE id = '$user_id'";

    if ($con->query($update_query) === TRUE) {
        // Update the session variable to reflect the new balance
        $_SESSION['balance'] = $new_balance;
        // Reload the page to see the updated balance
        header("Refresh:0");
    } else {
        echo "Error updating balance: " . mysqli_error($con);
    }
}

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

$_SESSION['new_balance'] = $new_balance;
$_SESSION['balance'] = $balance;




?>




<!-- HTML -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <title>Edit Page</title>
</head>
<body>

<div class="full-container">

    <form method="post">
    <div class="input-container">
        <input type="text" name="name" placeholder="Name"></input>
        <input type="text" name="description" placeholder="Description"></input> 
        <input type="number" step="0.01" name="price" placeholder="Price"></input>
        <button type="submit"><i class="fas fa-cloud-upload-alt"></i></button>

    </div>    
        
        <?php if(!empty($error_message)) { ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php } ?>
    </form>
    
  

<div class="balance-container">
    <div class="balance">
        <h1>Balance</h1>
        <h2>€ <?php echo $balance; ?></h2>
    </div>
        <div class="input-balance-container">
        <form method="post">
            <input type="number" name="balance" placeholder="New Balance">
            <button type="submit"><i class="fas fa-cloud-upload-alt"></i></button>
        </form>
    </div>
</div>


        
<div id="list">
    <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>

        <tbody>


        <!-- LIST -->

        <?php
        $user_id = $_SESSION['id']; // get the currently logged-in user's ID
        $sql = "SELECT * FROM soort_uitgave WHERE user_id = '$user_id'";
        $result = $con->query($sql);

        if ($result === false) {
            die("Invalid query: " . mysqli_error($con));
        }
        

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["naam"] . "</td>
                    <td>" . $row["info"] . "</td>
                    <td>" . $row["prijs"] . "</td>
                    <td>
                    <form method='post' action='delete.php'>
                        <input type='hidden' name='id' value='" . $row["id"] . "'>
                        <button type='submit'>Delete</button>
                    </form>
                    </td>
                </tr>";

        }
        
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
