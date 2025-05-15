<?php
include 'db.php';
$conn = new mysqli("localhost:3307", "root", "12345", "stray_heart");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $breed = $_POST['breed'];
    $species = $_POST['species'];
    $description = $_POST['description'];

    $image = $_FILES['image']['name'];
    $temp = $_FILES['image']['tmp_name'];
    $target = "uploads/pets/" . basename($image);

   
    if(move_uploaded_file($temp, $target)) {
        $sql = "INSERT INTO pets (name, age, breed,species, description, image) 
                VALUES ('$name', '$age', '$breed','$species','$description', '$image')";
        if($conn->query($sql) === TRUE) {
            echo "<script>alert('Pet added successfully!'); window.location.href='pet_list.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Failed to upload image.";
    }
}
?>
