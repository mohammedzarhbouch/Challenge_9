<?php
    $servername = "localhost";
    $username = "challenge9";
    $password = "12345";
    $dbname = "challenge9";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if($conn->connect_error){
        die("connection failed".$conn->connect_error);
    }
    echo"";
?>