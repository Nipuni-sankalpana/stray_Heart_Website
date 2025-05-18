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
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .adoption-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .adoption-table th {
            background-color: #3498db;
            color: white;
            padding: 12px 15px;
            text-align: left;
        }
        
        .adoption-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .adoption-table tr:last-child td {
            border-bottom: none;
        }
        
        .adoption-table tr:hover {
            background-color: #f5f5f5;
        }
        
        .status-pending {
            color: #e67e22;
            font-weight: bold;
        }
        
        .status-accepted {
            color: #27ae60;
            font-weight: bold;
        }
        
        .status-rejected {
            color: #e74c3c;
            font-weight: bold;
        }
        
        .action-btn {
            display: inline-block;
            padding: 6px 12px;
            margin: 0 5px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .accept-btn {
            background-color: #2ecc71;
            color: white;
        }
        
        .accept-btn:hover {
            background-color: #27ae60;
        }
        
        .reject-btn {
            background-color: #e74c3c;
            color: white;
        }
        
        .reject-btn:hover {
            background-color: #c0392b;
        }
        
        .no-requests {
            text-align: center;
            padding: 20px;
            color: #7f8c8d;
            font-style: italic;
        }
    </style>
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