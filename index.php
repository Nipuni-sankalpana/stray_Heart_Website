
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Stray Heart - Pet Adoption</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
   <!-- Custom CSS -->
   <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
 <!-- Bootstrap Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">
      <span style="color: #e3d7ed">Stray</span> <span style="color:black">Heart</span>
    </a>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="pet_list.php">Pet List</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="hospital.php">Hospitals</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="donation.php">Donation</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="user-dashboard.php">user dashboard</a>
        </li>
        <li class="nav-item ms-lg-3">
          <a class="nav-link btn-adopt" href="add-pet.php" id="addPetBtn">Add Pet</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        /* Navbar styles */
        .navbar {
            background-color: transparent !important;
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
            color: white !important;
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
   

  <div class="flex-container">
    <div class="child-1">
      <div class="content">
        <h1>Stray <span>Heart</span></h1>
        <span class="welcome-text">Welcome to our paw family..</span>
        <p>
         At Stray Heart, we believe every stray has a story—and every heart, no matter how small, deserves love. Our mission is to bridge the gap between lonely paws and loving homes, because no furry soul should walk this world unseen. Whether you're here to adopt, volunteer, or simply share in our compassion, you’re now part of a community that beats for the voiceless.
        </p>
        
        <a href="signup.php" class="btn btn-outline-secondary">Get Started</a>

      </div>
    </div>
    <div class="child-2">
      
      <img
        src="assets/images/Home.jpeg"
        alt="Happy dog waiting for adoption"
      />
    </div>
  </div>

  
  <section class="process-section">
    <h2 class="section-title">Our Adoption Process</h2>
    <div class="process-cards">
      
      <div class="process-card">
        <div class="process-icon">
          <i class="fas fa-search"></i>
        </div>
        <h3>1. Find Your Pet</h3>
        <p>Browse our available pets and find your perfect match based on your lifestyle and preferences.</p>
      </div>
      
     
      <div class="process-card">
        <div class="process-icon">
          <i class="fas fa-file-alt"></i>
        </div>
        <h3>2. Submit Application</h3>
        <p>Complete our adoption application form with your details and pet preferences.</p>
      </div>
      
      
      <div class="process-card">
        <div class="process-icon">
          <i class="fas fa-handshake"></i>
        </div>
        <h3>3. Meet & Greet</h3>
        <p>Schedule a visit to meet your potential new family member in person.</p>
      </div>
      
      
      <div class="process-card">
        <div class="process-icon">
          <i class="fas fa-home"></i>
        </div>
        <h3>4. Finalize Adoption</h3>
        <p>Complete the paperwork and bring your new pet home to start your life together!</p>
      </div>
    </div>
  </section>
  <section id="reviews" class="container my-5">
  <h2 class="text-center mb-4">What People Are Saying</h2>
  <div class="row">
  </div>
</section>

     
  <section class="text-center my-5">
  <h2 class="mb-3">Share Your Experience</h2>
  <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">Write a Review</button>
</section>
<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="submit_review.php" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Submit Your Review</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text" name="username" class="form-control mb-3" placeholder="Your Name" required>
        <textarea name="message" class="form-control mb-3" placeholder="Write your review..." required></textarea>
      </div>
      <div class="modal-footer">
        <button type="submit" name="submit_review" class="btn btn-primary">Submit Review</button>
      </div>
    </form>
  </div>
</div>

  
    


  <!-- Footer -->
  <footer class="text-center text-lg-start bg-body-white shadow-sm mt-5">
    <section
      class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom"
    >
      <div class="me-5 d-none d-lg-block">
        <span>Get connected with us on social networks:</span>
      </div>
      <div>
        <a href="#" class="me-4 text-reset"
          ><i class="fab fa-facebook-f"></i
        ></a>
        <a href="#" class="me-4 text-reset"><i class="fab fa-twitter"></i></a>
        <a href="#" class="me-4 text-reset"><i class="fab fa-google"></i></a>
        <a href="#" class="me-4 text-reset"
          ><i class="fab fa-instagram"></i
        ></a>
        <a href="#" class="me-4 text-reset"
          ><i class="fab fa-linkedin"></i
        ></a>
        <a href="#" class="me-4 text-reset"><i class="fab fa-github"></i></a>
      </div>
    </section>

    <section class="">
      <div class="container text-center text-md-start mt-5">
        <div class="row mt-3">
          <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
            <h6 class="text-uppercase fw-bold mb-4">Stray Heart</h6>
            <p>
              We are dedicated to connecting kind-hearted people with rescued
              animals in need of a loving home.
            </p>
          </div>
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
            <h6 class="text-uppercase fw-bold mb-4">What We Offer</h6>
            <p>
              <a href="#!" class="text-reset">Find Nearby Pet Hospitals</a>
            </p>
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
            <p>
              <i class="fas fa-envelope me-3"></i>
              sankalpananipuni132@gmail.com
            </p>
            <p><i class="fas fa-phone me-3"></i> +94 77 260 5610</p>
            <p><i class="fas fa-print me-3"></i> +94 71 418 8560</p>
          </div>
        </div>
      </div>
    </section>

    <div
      class="text-center p-4"
      style="background-color: rgba(0, 0, 0, 0.05)"
    >
      © 2025 Copyright:
      <a class="text-reset fw-bold" href="#">StrayHeart.com</a>
    </div>
  </footer>

  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  
  
</body>
</html>
