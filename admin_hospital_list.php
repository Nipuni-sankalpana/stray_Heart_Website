<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Hospital List - Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
</head>
<body>
  
<div class="container mt-5">
  <h2>Hospital List</h2>
 <a href="add_hospital.php" class="btn mb-3" style="background-color:#E3D7ED; color: black;">+ Add Hospitals</a>
 <a href="admin_dashboard.php" class="btn mb-3" style="background-color:#E3D7ED; color: black;">← Back</a>


  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Name</th>
        <th>Location</th>
        <th>Contact</th>
        <th>Services</th>
        <th>About</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $result = mysqli_query($conn, "SELECT * FROM hospitals");
      while ($row = mysqli_fetch_assoc($result)) {
      ?>
      <tr>
        <td><?= $row['name'] ?></td>
        <td><?= $row['location'] ?></td>
        <td><?= $row['contact'] ?></td>
        <td><?= $row['services'] ?></td>
        <td><?= $row['about'] ?></td>
        <td>
          <a href="edit_hospital.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="delete_hospital.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  
</div>
</body>
</html>