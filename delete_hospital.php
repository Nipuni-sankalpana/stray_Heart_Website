<?php
include 'db.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM hospitals WHERE id=$id");

header("Location: admin_hospital_list.php");
?>