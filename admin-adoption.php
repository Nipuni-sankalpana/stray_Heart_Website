<?php
include 'db.php';
$result = $conn->query("SELECT a.*, u.name AS user_name, u.email, p.name AS pet_name FROM adoptions a JOIN users u ON a.user_id = u.id JOIN pets p ON a.pet_id = p.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Adoption Requests</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
  <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f9f9f9;
        padding: 30px;
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
        color: #5a2a83;
    }

    .back-btn {
        display: inline-block;
        margin-bottom: 20px;
        background-color: #dcd3e3;
        color: #333;
        padding: 8px 16px;
        text-decoration: none;
        border-radius: 6px;
        transition: background-color 0.2s;
    }

    .back-btn:hover {
        background-color: #c5b6d4;
    }

    .adoption-table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .adoption-table th,
    .adoption-table td {
        padding: 14px;
        text-align: center;
        border-bottom: 1px solid #e0e0e0;
    }

    .adoption-table th {
        background-color: #eadcf0;
        color: #4b2c5e;
    }

    .status-pending {
        color: #d29f00;
        font-weight: bold;
    }

    .status-accepted {
        color: green;
        font-weight: bold;
    }

    .status-rejected {
        color: red;
        font-weight: bold;
    }

    .action-btn {
        text-decoration: none;
        padding: 6px 12px;
        border-radius: 5px;
        color: white;
        font-size: 14px;
        margin: 0 5px;
        display: inline-block;
        transition: background-color 0.2s ease;
    }

    .accept-btn {
        background-color: #28a745;
    }

    .accept-btn:hover {
        background-color: #218838;
    }

    .reject-btn {
        background-color: #dc3545;
    }

    .reject-btn:hover {
        background-color: #c82333;
    }

    .no-requests {
        text-align: center;
        font-size: 18px;
        color: #888;
        margin-top: 50px;
    }
  </style>
</head>

<body>
  <a href="admin_dashboard.php" class="back-btn">← Back</a>

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
            <td><?= htmlspecialchars($row['user_name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['pet_name']) ?></td>
            <td class="status-<?= strtolower($row['status']) ?>">
              <?= htmlspecialchars($row['status']) ?>
            </td>
            <td>
              <?php if ($row['status'] == 'Pending'): ?>
                <a href="process_adoption.php?id=<?= $row['id'] ?>&action=accept" class="action-btn accept-btn">Accept</a>
                <a href="process_adoption.php?id=<?= $row['id'] ?>&action=reject" class="action-btn reject-btn">Reject</a>
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
