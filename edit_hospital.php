<?php
include 'db.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM hospitals WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $location = $_POST['location'];
  $contact = $_POST['contact'];
  $services = $_POST['services'];
  $about = $_POST['about'];

  $sql = "UPDATE hospitals SET name='$name', location='$location', contact='$contact', services='$services', about='$about' WHERE id=$id";
  mysqli_query($conn, $sql);
  header("Location: admin_hospital_list.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Hospital</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <h2>Edit Hospital</h2>
  <form method="POST">
    <input class="form-control mb-2" name="name" value="<?= $row['name'] ?>" required>
    <input class="form-control mb-2" name="location" value="<?= $row['location'] ?>" required>
    <input class="form-control mb-2" name="contact" value="<?= $row['contact'] ?>" required>
    <input class="form-control mb-2" name="services" value="<?= $row['services'] ?>" required>
    <textarea class="form-control mb-2" name="about" required><?= $row['about'] ?></textarea>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="admin_hospital_list.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
</body>
</html>
