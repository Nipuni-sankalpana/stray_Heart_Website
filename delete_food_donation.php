<?php
include 'db.php';
session_start();


 if (!isset($_SESSION['admin_logged_in'])) {
     header("Location: login.php");
     exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    
    $stmt = $conn->prepare("DELETE FROM food_donations WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Donation deleted successfully.'); window.location.href='admin_food_donations.php';</script>";
    } else {
        echo "<script>alert('Failed to delete donation.'); window.location.href='admin_food_donations.php';</script>";
    }

    $stmt->close();
} else {
    header("Location: admin_food_donations.php");
}
?>
