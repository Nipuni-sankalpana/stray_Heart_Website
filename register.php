<?php
include 'db.php';

$message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $admin_emails = ['admin@example.com']; 
    $role = in_array($email, $admin_emails) ? 'admin' : 'user';

    $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $password, $role);

    if ($stmt->execute()) {
        $message = "<p style='color: green;'>Signup successful. <a href='login.php'>Login here</a></p>";
    } else {
        $message = "<p style='color: red;'>Signup failed: " . $stmt->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Signup - Pet Adoption</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/signup.css" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-image: url(assets/images/hospital\ bg.png);
      background-size: cover;
      background-position: center;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      flex-direction: column;
      text-align: center;
    }
    .signup-container {
      background: rgba(255, 255, 255, 0.9);
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
      width: 90%;
      max-width: 400px;
    }
    .btn-signup {
      background-color:black;
      color: #E3D7ED;
      border: none;
      padding: 0.75rem 1.5rem;
      border-radius: 30px;
      cursor: pointer;
      font-weight: bold;
    }
    .btn-signup:hover {
      background-color: #E3D7ED;
      color:black;
    }
  </style>
</head>
<body>

  <div class="welcome-message">
    <h1>Welcome to Stray Heart</h1>
    <p>Join a community that cares. Sign up to adopt, donate, and change lives—one paw at a time!</p>
  </div>

  <div class="signup-container">
    <img src="assets/images/pets_15721614.png" alt="Pet Logo" class="form-logo" />
    <h2>Join the Paw-sitive Family!</h2>
    <p class="tagline">Adopt, love, and save lives.</p>

    <?= $message ?> 

    <form action="" method="POST" class="signup-form">
      <input type="text" name="name" placeholder="Full Name" required />
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit" class="btn-signup">Sign Up</button>
    </form>

    <p class="login-link">Already have an account? <a href="login.php">Login here</a></p>
  </div>

</body>
</html>
