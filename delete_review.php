<?php
include 'db.php';
$id = intval($_GET['id']);
mysqli_query($conn, "DELETE FROM reviews WHERE id = $id");
header("Location: manage_reviews.php");
?>
