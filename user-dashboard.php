<?php
session_start();
$conn = new mysqli("localhost:3307", "root", "12345", "stray_heart");




$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT a.*, p.name AS pet_name 
                        FROM adoptions a 
                        JOIN pets p ON a.pet_id = p.id 
                        WHERE a.user_id = $user_id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; }
        th, td { padding: 10px; border: 1px solid #ccc; }
        th { background-color: #7f00ff; color: white; }
    </style>
</head>
<body>
    
<h2>👤 Welcome to Your Dashboard</h2>

<h3>🐾 My Adoption Requests</h3>
<table>
    <tr>
        <th>Pet</th>
        <th>Status</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['pet_name']) ?></td>
            <td>
                <?php if ($row['status'] == 'Pending'): ?>
                    ⏳ Pending
                <?php elseif ($row['status'] == 'Accepted'): ?>
                    ✅ Accepted
                <?php else: ?>
                    ❌ Rejected
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="2">No adoption requests yet.</td></tr>
    <?php endif; ?>
</table>

</body>
</html>
