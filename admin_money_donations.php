<?php
include 'db.php';
session_start();


$result = $conn->query("SELECT m.*, u.name FROM money_donations m JOIN users u ON m.user_id = u.id ORDER BY m.donation_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Money Donations</title>
</head>
<body>
<h1>Money Donations</h1>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>User</th>
        <th>Amount (LKR)</th>
        <th>Payment Method</th>
        <th>Donation Date</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo number_format($row['amount'], 2); ?></td>
        <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
        <td><?php echo $row['donation_date']; ?></td>
    </tr>
    <?php } ?>
</table>
</body>
</html>
