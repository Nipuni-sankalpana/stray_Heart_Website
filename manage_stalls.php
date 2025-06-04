<?php

include 'db.php';

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM pet_stall WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: manage_stalls.php?deleted=1");
    exit();
}

$stalls = $conn->query("SELECT * FROM pet_stall ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Pet Stalls</title>
    <style>
        body { font-family: Arial; padding: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #E3D7ED; color: black; }
        .btn { padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; }
        .edit { background: #ff9800; color: white; }
        .delete { background: #f44336; color: white; }
        .add { background: #4CAF50; color: white; margin-bottom: 10px; display: inline-block; padding: 8px 15px; text-decoration: none; }
        .success { color: green; }
    </style>
</head>
<body>

<h2>Manage Pet Stalls</h2>
<a href="admin_add_stall.php" class="btn mb-3" style="background-color:#E3D7ED; color: black;">+Add New Stalls</a>
<a href="admin_dashboard.php" class="btn mb-3" style="background-color:#E3D7ED; color: black;">← Back</a>


<?php if (isset($_GET['deleted'])): ?>
    <p class="success">Stall deleted successfully.</p>
<?php endif; ?>

<table>
    <tr>
        <th>ID</th>
        <th>Address</th>
        <th>Open Hours</th>
        <th>Contact</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $stalls->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= nl2br(htmlspecialchars($row['address'])) ?></td>
        <td><?= $row['open_hours'] ?></td>
        <td><?= $row['contact'] ?></td>
        <td>
            <a class="btn edit" href="edit_stall.php?id=<?= $row['id'] ?>">Edit</a>
            <a class="btn delete" href="manage_stalls.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure to delete this stall?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
