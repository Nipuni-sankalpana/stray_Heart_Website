<?php
include 'db.php';
session_start();

// Optional: Admin check
// if (!isset($_SESSION['admin_logged_in'])) {
//     header("Location: login.php");
//     exit;
// }

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM item_donations WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Item donation deleted successfully.'); window.location.href='admin_item_donations.php';</script>";
    } else {
        echo "<script>alert('Failed to delete item donation.'); window.location.href='admin_item_donations.php';</script>";
    }

    $stmt->close();
} else {
    header("Location: admin_item_donations.php");
}
?>
