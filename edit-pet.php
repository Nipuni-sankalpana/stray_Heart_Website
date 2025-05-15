<?php

include 'db.php';
$conn = new mysqli("localhost:3307", "root", "12345", "stray_heart");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM pets WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $pet = $result->fetch_assoc();
    } else {
        echo "❌ Pet not found!";
        exit;
    }
} else {
    echo "❌ Invalid request!";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pet</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f2f2f2; }
        form { background: white; padding: 20px; max-width: 500px; margin: auto; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        input, textarea, button { width: 100%; margin-bottom: 10px; padding: 10px; font-size: 16px; }
        img { max-width: 100px; display: block; margin-bottom: 10px; }
    </style>
</head>
<body>

<h2>Edit Pet</h2>

<form action="update-pet.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $pet['id'] ?>">

    <label>Pet Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($pet['name']) ?>" required>

    <label>Age:</label>
    <input type="text" name="age" value="<?= htmlspecialchars($pet['age']) ?>" required>

    <label>Breed:</label>
    <input type="text" name="breed" value="<?= htmlspecialchars($pet['breed']) ?>" required>

    <label>Species:</label>
    <input type="text" name="species" value="<?= htmlspecialchars($pet['species']) ?>" required>

    <label>Description:</label>
    <textarea name="description" rows="4" required><?= htmlspecialchars($pet['description']) ?></textarea>

    <label>Current Image:</label>
    <img src="uploads/pets/<?= $pet['image'] ?>" alt="Pet Image">

    <label>Upload New Image (optional):</label>
    <input type="file" name="image">

    <button type="submit" name="update">Update Pet</button>
</form>

</body>
</html>
