<?php
include 'db.php';
session_start();
// Add admin check here

$result = $conn->query("SELECT i.*, u.name FROM item_donations i JOIN users u ON i.user_id = u.id ORDER BY i.donation_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Item Donations</title>
</head>
<body>
<h1>Item Donations</h1>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>User</th><th>Item Name</th><th>Quantity</th><th>Message</th>
        <th>Donation Date</th><th>Confirmed</th><th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['item_name']); ?></td>
        <td><?php echo htmlspecialchars($row['quantity']); ?></td>
        <td><?php echo htmlspecialchars($row['message']); ?></td>
        <td><?php echo $row['donation_date']; ?></td>
        <td><?php echo $row['confirmed_by_admin'] ? 'Yes' : 'No'; ?></td>
        <td>
            <?php if (!$row['confirmed_by_admin']) { ?>
                <a href="confirm_item_donation.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Confirm this item donation?');">Confirm</a>
            <?php } else { ?>
                Confirmed
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>
</body>
</html>
