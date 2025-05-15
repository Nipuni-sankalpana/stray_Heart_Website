<?php
include 'db.php';
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM donations WHERE user_id = $user_id ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<h2>Donation Confirmation</h2>
<p>Thank you for your donation!</p>
<p>Donation Type: <?php echo $row['donation_type']; ?></p>
<p>Amount (if money): <?php echo $row['donation_type'] == 'money' ? $row['amount'] : 'N/A'; ?></p>
<p>Your donation message: <?php echo $row['message']; ?></p>
<p>Status: <?php echo $row['status']; ?></p>
