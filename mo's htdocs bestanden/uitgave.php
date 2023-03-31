<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "challenge9";

$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error){
    die("connection failed".$conn->connect_error);
}

if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $sql = "INSERT INTO soort_uitgave (naam, info, prijs) VALUES ('$name', '$description', '$price')";


    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="universal_header.css">
    <link rel="stylesheet" href="uitgave.css">
    <title>Document</title>
</head>
<body>
<form method="post">
    <div class="inputs">
    <input name="name" placeholder="Name"></input>
    <input name="description" placeholder="Description"></input> 
    <input name="price" placeholder="Price"></input>
    <button type="submit">+</button>
    </div>
</form>

<div id="list">
        <table class="table">
                <thead>
                    <tr>
                        <th>Name</th> 
                        <th>Description</th>
                        <th>Price</th>
                        
                        
                    </tr>
                </thead>

            <tbody>
                <?php
                    $sql = "SELECT * FROM soort_uitgave";
                    $result = $conn->query($sql);

                    if(!$result){
                        die("invalid query: " . $conn->error);
                    }

                    while($row = $result->fetch_assoc()){
                        echo"<tr>
                        <td>" . $row["naam"] . "</td>
                        <td>" . $row["info"] . "</td>
                        <td>" . $row["prijs"] . "</td>
                        </tr>";
                    }
                    
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
