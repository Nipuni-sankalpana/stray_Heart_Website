<?php
include 'db.php';

if (isset($_POST['submit_review'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $avatar = 'default.png'; // you can update this with a file upload if needed

    $sql = "INSERT INTO reviews (username, message, avatar) VALUES ('$username', '$message', '$avatar')";
    mysqli_query($conn, $sql);
    header("Location: index.php#reviews");
}
?>
