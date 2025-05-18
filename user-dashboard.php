<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to login if user is not logged in
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost:3307", "root", "12345", "stray_heart");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT a.*, p.name AS pet_name 
                        FROM adoptions a 
                        JOIN pets p ON a.pet_id = p.id 
                        WHERE a.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 20px;
        }
        h2, h3 {
            color: #7f00ff;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
            background: #fff; 
        }
        th, td { 
            padding: 10px; 
            border: 1px solid #ccc; 
            text-align: center;
        }
        th { 
            background-color: #7f00ff; 
            color: white; 
        }
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
