<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $location = $_POST['location'];
  $contact = $_POST['contact'];
  $services = $_POST['services'];
  $about = $_POST['about'];

  $sql = "INSERT INTO hospitals (name, location, contact, services, about) VALUES ('$name', '$location', '$contact', '$services', '$about')";
  mysqli_query($conn, $sql);
  header("Location: admin_hospital_list.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Hospital</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <h2>Add Hospital</h2>
  <form method="POST">
    <input class="form-control mb-2" name="name" placeholder="Hospital Name" required>
    <input class="form-control mb-2" name="location" placeholder="Location" required>
    <input class="form-control mb-2" name="contact" placeholder="Contact" required>
    <input class="form-control mb-2" name="services" placeholder="Services" required>
    <textarea class="form-control mb-2" name="about" placeholder="About Hospital" required></textarea>
    <button type="submit" class="btn btn-success">Add Hospital</button>
    <a href="admin_hospital_list.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
</body>
</html>
