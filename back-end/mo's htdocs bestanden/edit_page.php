<?php
session_start();
require_once('conn.php');

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

if(isset($_POST['categorie']) &&  isset($_POST['price'])) {
    $categorie = $_POST['categorie'];
    $price = $_POST['price'];
    $user_id = $_SESSION['id']; // get the currently logged-in user's ID

    if(empty($categorie) || empty($price)) {
        $error_message = "Please fill out all required fields";
    } else {
        $sql = "INSERT INTO budget (categorie, price, user_id) VALUES ('$categorie', '$price', '$user_id')";

        if ($con->query($sql) === TRUE) {
            header("Refresh:0");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
    }
}   


$user_id = $_SESSION['id']; // get the currently logged-in user's ID
$sql = "SELECT * FROM budget WHERE user_id = '$user_id'";
$transactieSql = "SELECT * FROM soort_uitgave WHERE user_id = '$user_id'";
$result = $con->query($sql);
$transactieResult = $con->query($transactieSql);

$new_balance = $_SESSION['new_balance'];
$balance = $_SESSION['balance'];

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

    
        <div class="list-container">
        <div class="budget-list">
        <form method="post">  
        <a class="title">Budget</a>
            <div class="budget-input">
                <input type="text" name="categorie" placeholder="categorie"></input>
                <input type="number" step="0.01" name="price" placeholder="Price"></input>
                <button type="submit"><i class="fas fa-cloud-upload-alt"></i></button>
            </div>    
        <?php if(!empty($error_message)) { ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php } ?>
        </form>
                <table class="table">
                <thead>
                    <tr>
                        <th>Categorie</th>
                        <th>Price</th> 
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["categorie"] . "</td>
                                <td>€" . $row["price"] . "</td>
                                <td>
                                <form method='post' action='budget-delete.php'>
                                    <input type='hidden' name='id' value='" . $row["id"] . "'>
                                    <button type='submit' class='delete-button'>Delete</button>
                                </form>
                                </td>
                            </tr>";
                    }
                    
                    ?>
                </tbody>
                </table>
        </div>     
    </div>
    <div class="list-container">   
    <form method="post">
    <a class="title" >Transactions</a>
    <div class="input-container">
    
        <input type="text" name="name" placeholder="Name"></input>
        <input type="text" name="description" placeholder="Description"></input> 
        <input type="number" step="0.01" name="price" placeholder="Price"></input>
        <button type="submit"><i class="fas fa-cloud-upload-alt"></i></button>
    </div> 
    </form>
        <div class="transactie-list">
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

                <?php

                if ($result === false) {
                    die("Invalid query: " . mysqli_error($con));
                }
                while ($transactieRow = $transactieResult->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $transactieRow["name"] . "</td>
                            <td>" . $transactieRow["info"] . "</td>
                            <td>€" . $transactieRow["price"] . "</td>
                            <td>
                            <form method='post' action='delete.php'>
                                <input type='hidden' name='id' value='" . $transactieRow["id"] . "'>
                                <button type='submit' class='delete-button'>Delete</button>
                            </form>
                            </td>
                        </tr>";

                }
                
                ?>
                </tbody>
            </table>
        </div>
        </div>
</div>
</body>
</html>
