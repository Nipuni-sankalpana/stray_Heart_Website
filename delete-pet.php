<?php
include 'db.php';
$conn = new mysqli("localhost:3307", "root", "12345", "stray_heart");
$id = $_GET['id'];

$conn->query("DELETE FROM pets WHERE id=$id");

echo "<script>alert('Pet deleted successfully!'); window.location.href='manage-pets.php';</script>";
?>
