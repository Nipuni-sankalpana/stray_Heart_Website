<?php
session_start();
include 'db.php';

// Fetch pet stall info
$stall = $conn->query("SELECT * FROM pet_stall LIMIT 1");
$stall_info = $stall->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Stray Heart - Pet Adoption</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="assets/css/style.css" />
  <style>
    /* Navbar customization */
.navbar {
  background-color:#E3D7ED !important;
}

.navbar-brand {
  font-weight: 700;
  color: #e3d7ed !important;
}

.nav-link {
  color: black !important;
  font-weight: 500;
  margin: 0 5px;
  transition: all 0.3s ease;
}

.nav-link:hover {
  color: black !important;
  transform: translateY(-2px);
}

.btn-adopt {
  background-color: #E3D7ED;
  color: black !important;
  border-radius: 50px;
  padding: 8px 20px !important;
  font-weight: 600;
}

.btn-adopt:hover {
  background-color: #d0c4dd;
  transform: translateY(-2px);
}


  </style>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#"><span style="color: black;">Stray</span> <span style="color:white;">Heart</span></a>
        <button class="navbar-toggler bg-black" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="pet_list.php">Pet List</a></li>
                <li class="nav-item"><a class="nav-link" href="hospital.php">Hospitals</a></li>
                <li class="nav-item"><a class="nav-link" href="donate.php">Donation</a></li>
               
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Admin</a></li>
                <?php endif; ?>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle fa-lg"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="profile.php">View Profile</a></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link btn-adopt" href="login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>


<!-- Hero Section -->
<div class="flex-container">
  <div class="child-1">
    <div class="content">
      <h1>Stray <span>Heart</span></h1>
      <span class="welcome-text">Welcome to our paw family.. 🐶🐱</span>
      <p>
        At Stray Heart, we believe every stray has a story—and every heart, no matter how small, deserves love.
        Whether you're here to adopt, volunteer, or share in our compassion, you're now part of a community that beats for the voiceless.
      </p>
      <a href="login.php" class="btn btn-outline-secondary">Get Started</a>
    </div>
  </div>
  <div class="child-2">
    <img src="assets/images/Home.jpeg" alt="Happy dog waiting for adoption" />
  </div>
</div>

<!-- Process Section -->
<section class="process-section">
  <h2 class="section-title">Our Adoption Process</h2>
  <div class="process-cards">
    <div class="process-card">
      <div class="process-icon"><i class="fas fa-search"></i></div>
      <h3>1. Find Your Pet</h3>
      <p>Browse our available pets and find your perfect match.</p>
    </div>
    <div class="process-card">
      <div class="process-icon"><i class="fas fa-file-alt"></i></div>
      <h3>2. Submit Application</h3>
      <p>Complete our adoption application form.</p>
    </div>
    <div class="process-card">
      <div class="process-icon"><i class="fas fa-handshake"></i></div>
      <h3>3. Meet & Greet</h3>
      <p>Schedule a visit to meet your potential new family member.</p>
    </div>
    <div class="process-card">
      <div class="process-icon"><i class="fas fa-home"></i></div>
      <h3>4. Finalize Adoption</h3>
      <p>Complete the paperwork and bring your pet home!</p>
    </div>
  </div>
</section>

<!-- Minimal Pet Stall Section -->
<section class="pet-stall-section py-5" style="background-color: #fafafa;">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="display-6 fw-bold " style="color: black;">Our Pet Stall</h2>
      <div class="divider mx-auto" style="background-color: #E3D7ED;"></div>
    </div>

    <?php if ($stall_info): ?>
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="stall-card p-4 rounded-3" style="background-color: white; border-left: 4px solid #E3D7ED;">
          <div class="row">
            <div class="col-md-4 border-end pe-4">
              <div class="text-center">
                <i class="fas fa-map-marker-alt fa-2x mb-3" style="color: black;"></i>
                <h5 style="color: black;">Location</h5>
                <p style="color: #424242;"><?= htmlspecialchars($stall_info['address']) ?></p>
              </div>
            </div>
            
            <div class="col-md-4 border-end px-4">
              <div class="text-center">
                <i class="far fa-clock fa-2x mb-3" style="color: black;"></i>
                <h5 style="color: black;">Hours</h5>
                <p style="color: #424242;"><?= htmlspecialchars($stall_info['open_hours']) ?></p>
              </div>
            </div>
            
            <div class="col-md-4 ps-4">
              <div class="text-center">
                <i class="fas fa-phone-alt fa-2x mb-3" style="color: black;"></i>
                <h5 style="color: black;">Contact</h5>
                <p style="color: #424242;"><?= htmlspecialchars($stall_info['contact']) ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php else: ?>
    <div class="text-center py-4">
      <i class="fas fa-paw fa-3x mb-3" style="color: #d1c4e9;"></i>
      <h4 style="color: #5e35b1;">Stall Information Coming Soon</h4>
    </div>
    <?php endif; ?>
  </div>
</section>


<!-- Footer -->
<footer class="text-center text-lg-start bg-body-white shadow-sm mt-5">
  <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
    <div class="me-5 d-none d-lg-block">
      <span>Get connected with us on social networks:</span>
    </div>
    <div>
      <a href="#" class="me-4 text-reset"><i class="fab fa-facebook-f"></i></a>
      <a href="#" class="me-4 text-reset"><i class="fab fa-twitter"></i></a>
      <a href="#" class="me-4 text-reset"><i class="fab fa-google"></i></a>
      <a href="#" class="me-4 text-reset"><i class="fab fa-instagram"></i></a>
      <a href="#" class="me-4 text-reset"><i class="fab fa-linkedin"></i></a>
      <a href="#" class="me-4 text-reset"><i class="fab fa-github"></i></a>
    </div>
  </section>

  <section class="">
    <div class="container text-center text-md-start mt-5">
      <div class="row mt-3">
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
          <h6 class="text-uppercase fw-bold mb-4">Stray Heart</h6>
          <p>We are dedicated to connecting kind-hearted people with rescued animals in need of a loving home.</p>
        </div>
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
          <h6 class="text-uppercase fw-bold mb-4">What We Offer</h6>
          <p><a href="#!" class="text-reset">Find Nearby Pet Hospitals</a></p>
          <p><a href="#!" class="text-reset">Online Donation</a></p>
          <p><a href="#!" class="text-reset">Adopt a Pet</a></p>
          <p><a href="#!" class="text-reset">Success Stories</a></p>
        </div>
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
          <h6 class="text-uppercase fw-bold mb-4">Useful links</h6>
          <p><a href="#!" class="text-reset">Home</a></p>
          <p><a href="#!" class="text-reset">Pet List</a></p>
          <p><a href="#!" class="text-reset">Hospital List</a></p>
          <p><a href="#!" class="text-reset">Donation</a></p>
        </div>
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
          <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
          <p><i class="fas fa-home me-3"></i> B/9 Batupitiya, Atala</p>
          <p><i class="fas fa-envelope me-3"></i> strayheartpet@gmail.com</p>
          <p><i class="fas fa-phone me-3"></i> +94 77 260 5610</p>
        </div>
      </div>
    </div>
  </section>

  <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05)">
    © 2025 Copyright:
    <a class="text-reset fw-bold" href="#">strayheartpet.com</a>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
