<?php
include 'db.php';
session_start();

// Optional: Admin check
// if (!isset($_SESSION['admin_logged_in'])) {
//     header("Location: login.php");
//     exit;
// }

$result = $conn->query("SELECT m.*, u.name FROM money_donations m JOIN users u ON m.user_id = u.id ORDER BY m.donation_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Money Donations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto;
        }
        th, td {
            padding: 12px;
            border: 1px solid #aaa;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h1 {
            text-align: center;
        }
        a {
            color: blue;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<h1>Money Donations</h1>
<table>
    <tr>
        <th>User</th>
        <th>Amount (LKR)</th>
        <th>Payment Method</th>
        <th>Donation Date</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo number_format($row['amount'], 2); ?></td>
        <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
        <td><?php echo $row['donation_date']; ?></td>
        <td>
            <a href="delete_money_donation.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this donation?');">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>
</body>
</html>
