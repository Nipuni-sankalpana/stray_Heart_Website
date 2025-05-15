<?php
include 'db.php';
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $breed = $_POST['breed'];
    $species = $_POST['species'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    
    $target_dir = "uploads/";
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    
    $sql = "INSERT INTO pets (name, age, breed,species, description, image, user_id) VALUES ('$name', '$age', '$breed','$species', '$description', '$image_name', '$user_id')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Pet uploaded successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<form method="post" enctype="multipart/form-data">
    Name: <input type="text" name="name" required><br>
    Age: <input type="number" name="age" required><br>
    Breed: <input type="text" name="breed" required><br>
    Species: <input type="text" name="species" required><br>
    Description: <textarea name="description" required></textarea><br>
    Image: <input type="file" name="image" required><br>
    <button type="submit">Upload Pet</button>
</form>
