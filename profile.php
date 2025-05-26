<?php
session_start();
require_once 'db.php'; // Make sure this connects to your DB

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    .profile-card {
      max-width: 600px;
      margin: 100px auto;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .profile-image {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      margin-bottom: 15px;
    }
    .card-header {
      background: #7f00ff;
      color: white;
      border-radius: 10px 10px 0 0;
      text-align: center;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="card profile-card">
    <div class="card-header">
      <h3><?php echo htmlspecialchars($user['name']); ?>'s Profile</h3>
    </div>
    <div class="card-body text-center">
      <?php if (!empty($user['profile_image'])): ?>
        <img src="uploads/<?php echo htmlspecialchars($user['profile_image']); ?>" class="profile-image" alt="Profile Image">
      <?php else: ?>
        <img src="assets/images/default-user.png" class="profile-image" alt="Default Profile">
      <?php endif; ?>
      
      <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
      <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
      
      <a href="user-dashboard.php" class="btn btn-primary mt-3">user dashboard</a>
    </div>
  </div>
</div>

</body>
</html>
