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
    <link rel="stylesheet" href="assets/css/manage-pets.css">
    
</head>
<body>

<h2>Admin Panel - Manage Pets</h2>
<a href="add-pet.php" class="btn mb-3" style="background-color:#E3D7ED; color: black;">+ Add Pet</a>
<a href="admin_dashboard.php" class="btn mb-3" style="background-color:#E3D7ED; color: black;">← Back</a>


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
