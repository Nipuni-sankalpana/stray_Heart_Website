<?php
include 'db.php';
session_start();


 if (!isset($_SESSION['admin_logged_in'])) {
     header("Location: login.php");
    exit;
 }

$result = $conn->query("SELECT f.*, u.name FROM food_donations f JOIN users u ON f.user_id = u.id ORDER BY f.donation_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Food Donations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #5a2a83;
        }

        .back-btn {
            display: inline-block;
            margin: 20px;
            background-color: #dcd3e3;
            color: #333;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.2s ease;
        }

        .back-btn:hover {
            background-color: #c5b6d4;
        }

        .message {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .success { color: green; }
        .error { color: red; }

        table {
            border-collapse: collapse;
            width: 90%;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #eee5f3;
            color: #4b2c5e;
        }

        td a {
            color: #007bff;
            text-decoration: none;
        }

        td a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<a href="admin_dashboard.php" class="back-btn">← Back</a>

<h1>Food Donations</h1>

<?php if (isset($_GET['msg'])): ?>
    <div class="message <?php echo $_GET['msg'] === 'confirmed' ? 'success' : 'error'; ?>">
        <?php
        if ($_GET['msg'] === 'confirmed') {
            echo "Donation confirmed and email sent successfully!";
        } elseif ($_GET['msg'] === 'email_failed') {
            echo "Donation confirmed, but email sending failed.";
        }
        ?>
    </div>
<?php endif; ?>

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
