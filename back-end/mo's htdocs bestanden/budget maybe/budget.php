<?php
 session_start();
 include 'conn.php';


 
 $user_id = $_SESSION['id']; // get the currently logged-in user's ID
        $sql = "SELECT * FROM budget WHERE user_id = '$user_id'";
        $result = $con->query($sql);

        if ($result === false) {
            die("Invalid query: " . mysqli_error($con));
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
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="budget.css">
    <title>Document</title>
</head>
<body>

<form method="post">
    <div class="input-container">
        <input type="text" name="categorie" placeholder="categorie"></input>
        <input type="number" step="0.01" name="price" placeholder="Price"></input>
        <button type="submit"><i class="fas fa-cloud-upload-alt"></i></button>

    </div>    
        
        <?php if(!empty($error_message)) { ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php } ?>
    </form>

    <div class="content">
    <table>
        <thead>
            <tr>
                <th>Categorie</th>
                <th>Prijs</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["categorie"] . "</td>
                        <td>" . $row["price"] . "</td>
                        <td>
                            <form method='post' action='deleteB.php'>
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


</body>
</html>