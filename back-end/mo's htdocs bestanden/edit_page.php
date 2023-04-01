<?php
session_start();

include('conn.php');

$error_message = "";

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
            echo "New record created successfully";
            echo "<script>
                  setTimeout(function() {
                    window.location.href = 'edit_page.php';
                  }, 3000);
                  </script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
    }
}

?>

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

<!-- <div class="balance-container">
    <div class="balance">
        <h1>Balance</h1>
        <h2>€ 0</h2>
    </div>
</div> -->

<div class="full-container">

    <form method="post">
    <div class="input-container">
        <input type="text" name="name" placeholder="Name"></input>
        <input type="text" name="description" placeholder="Description"></input> 
        <input type="text" name="price" placeholder="Price"></input>
        <button type="submit"><i class="far fa-paper-plane"></i></button>

    </div>    
        
        <?php if(!empty($error_message)) { ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php } ?>
    </form>

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
            </table
>
        </div>


</body>
</html>
