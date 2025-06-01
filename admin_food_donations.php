<?php
include 'db.php';
session_start();

// Optional: Only allow admin access
// if (!isset($_SESSION['admin_logged_in'])) {
//     header("Location: login.php");
//     exit;
// }

$result = $conn->query("SELECT f.*, u.name FROM food_donations f JOIN users u ON f.user_id = u.id ORDER BY f.donation_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Food Donations</title>
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
<h1>Food Donations</h1>
<table>
    <tr>
        <th>User</th>
        <th>Food Type</th>
        <th>Quantity</th>
        <th>Message</th>
        <th>Donation Date</th>
        <th>Confirmed</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['food_type']); ?></td>
        <td><?php echo htmlspecialchars($row['quantity']); ?> kg</td>
        <td><?php echo htmlspecialchars($row['message']); ?></td>
        <td><?php echo $row['donation_date']; ?></td>
        <td><?php echo $row['confirmed_by_admin'] ? 'Yes' : 'No'; ?></td>
        <td>
            <?php if (!$row['confirmed_by_admin']) { ?>
                <a href="confirm_food_donation.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Confirm this food donation?');">Confirm</a> |
            <?php } else { ?>
                Confirmed |
            <?php } ?>
            <a href="delete_food_donation.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this donation?');">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>
</body>
</html>
