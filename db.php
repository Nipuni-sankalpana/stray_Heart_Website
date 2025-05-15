<?php
$conn = new mysqli('localhost:3307', 'root', '12345', 'stray_heart');
if ($conn->connect_error) { die('Connection failed: ' . $conn->connect_error); }
?>