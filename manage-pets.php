<?php
include 'db.php';
$conn = new mysqli("localhost:3307", "root", "12345", "stray_heart");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM pets");
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
    <title>Manage Pets</title>
    <style>
        body { font-family: Arial; background: #f2f2f2; padding: 20px; }
        table {
            width: 100%; background: white;
            border-collapse: collapse;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px; text-align: left;
            border-bottom: 1px solid #ddd;
        }
        a.btn {
            padding: 5px 10px; text-decoration: none;
            border-radius: 5px; color: white;
        }
        .edit { background-color: #28a745; }
        .delete { background-color: #dc3545; }
        
    </style>
</head>
<body>

<h2>Admin Panel - Manage Pets</h2>
<a href="add-pet.php" class="btn btn-success mb-3">+ Add Pet</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Pet Name</th>
            <th>Breed</th>
            <th>Species</th>
            <th>Age</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['breed'] ?></td>
            <td><?= $row['species'] ?></td>
            <td><?= $row['age'] ?></td>
            <td><img src="uploads/pets/<?= $row['image'] ?>" width="80" height="60"></td>
            <td>
                <a href="edit-pet.php?id=<?= $row['id'] ?>" class="btn edit">Edit</a>
                <a href="delete-pet.php?id=<?= $row['id'] ?>" class="btn delete" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
