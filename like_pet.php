<?php
include 'db.php';
session_start();
$conn = new mysqli("localhost:3307", "root", "12345", "stray_heart");

if (!isset($_SESSION['user_id'])) {
    echo "Login required";
    exit;
}

$user_id = intval($_SESSION['user_id']);
$pet_id = intval($_POST['pet_id']);


$check = $conn->query("SELECT * FROM likes WHERE user_id=$user_id AND pet_id=$pet_id");

if ($check->num_rows > 0) {
    echo "Already liked";
} else {
    $insert = $conn->query("INSERT INTO likes (user_id, pet_id) VALUES ($user_id, $pet_id)");
    echo $insert ? "Liked" : "Error";
}
?>
