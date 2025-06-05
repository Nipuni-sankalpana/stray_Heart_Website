<?php
include 'db.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $age = $conn->real_escape_string($_POST['age']);
    $breed = $conn->real_escape_string($_POST['breed']);
    $species = $conn->real_escape_string($_POST['species']);
    $description = $conn->real_escape_string($_POST['description']);

    
    $uploadDir = "uploads/pets/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    
    if (!empty($_FILES['image']['name'])) {
        $imageName = basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;
        $tmpName = $_FILES['image']['tmp_name'];

        if (move_uploaded_file($tmpName, $imagePath)) {
           
            $sql = "UPDATE pets SET name='$name', age='$age', breed='$breed',species='$species', description='$description', image='$imageName' WHERE id=$id";
        } else {
            echo "❌ Failed to upload new image.";
            exit;
        }
    } else {
        
        $sql = "UPDATE pets SET name='$name', age='$age', breed='$breed',species='$species', description='$description' WHERE id=$id";
    }

    if ($conn->query($sql)) {
        echo "<script>alert('✅ Pet updated successfully!'); window.location.href='manage-pets.php';</script>";
    } else {
        echo "❌ Error updating pet: " . $conn->error;
    }
}
?>
