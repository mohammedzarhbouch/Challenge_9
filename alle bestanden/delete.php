<?php
session_start();

include('conn.php');

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    $user_id = $_SESSION['id'];

    $sql = "DELETE FROM soort_uitgave WHERE id = '$id' AND user_id = '$user_id'";

    if ($con->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }

    // Redirect back to the edit_page.php file
    header("Location: edit_page.php");
    exit();
}
?>
