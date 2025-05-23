<?php
include 'db.php';
$result = $conn->query("SELECT a.*, u.name AS user_name, u.email, p.name AS pet_name FROM adoptions a JOIN users u ON a.user_id = u.id JOIN pets p ON a.pet_id = p.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Requests</title>
    <link rel="stylesheet" href="\assets\css\admin-adoption.css">
</head>
<body>
    <h1>Adoption Requests</h1>
    
    <?php if ($result->num_rows > 0): ?>
        <table class="adoption-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Pet</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['pet_name']); ?></td>
                        <td class="status-<?php echo strtolower($row['status']); ?>">
                            <?php echo htmlspecialchars($row['status']); ?>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'Pending'): ?>
                                <a href="process_adoption.php?id=<?php echo $row['id']; ?>&action=accept" class="action-btn accept-btn">Accept</a>
                                <a href="process_adoption.php?id=<?php echo $row['id']; ?>&action=reject" class="action-btn reject-btn">Reject</a>
                            <?php else: ?>
                                <span>No actions available</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-requests">No adoption requests found.</div>
    <?php endif; ?>
</body>
</html>