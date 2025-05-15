<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Signup - Pet Adoption</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/signup.css" />
 
</head>
<body>
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
  </style>

  <div class="welcome-message">
    <h1>Welcome to Stray Heart </h1>
    <p>Join a community that cares. Sign up to adopt, donate, and change lives—one paw at a time!</p>
  </div>

  <div class="signup-container">
    <img src="assets/images/pets_15721614.png" alt="Pet Logo" class="form-logo" />
    <h2>Join the Paw-sitive Family!</h2>
    <p class="tagline">Adopt, love, and save lives.</p>
    
    <form action="register.php" method="POST" class="signup-form">
      <input type="text" name="name" placeholder="Full Name" required />
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit" class="btn-signup">Sign Up</button>
    </form>
    
    <p class="login-link">Already have an account? <a href="login.php">Login here</a></p>
  </div>

</body>
</html>
