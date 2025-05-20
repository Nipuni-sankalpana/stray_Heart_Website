<?php
include 'db.php';
$query = "SELECT * FROM hospitals ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Hospital List - Stray Heart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
  <!-- Custom CSS -->
  <style>
    :root {
      --lavender: #E6E6FA;
      --dark-lavender: #B399D4;
      --deep-purple: #5D3A9B;
      --black: #1A1A1A;
      --white: #FFFFFF;
      --light-gray: #F8F8F8;
    }
    
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: var(--white);
      color: var(--black);
      line-height: 1.6;
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
      color: #e3d7ed;
      transform: translateY(-2px);
    }
    .btn-adopt {
            background-color: #E3D7ED;
            color:  black !important;
            border-radius: 50px;
            padding: 8px 20px !important;
            font-weight: 600;
        }

        .btn-adopt:hover {
            background-color:black;
             color:  #E3D7ED !important;
            transform: translateY(-2px);
        }
    
    /* Hero Section */
    .hero-section {
      background: linear-gradient(135deg, var(--lavender) 0%, var(--white) 100%);
      padding: 100px 0 80px;
      margin-bottom: 60px;
      position: relative;
      overflow: hidden;
    }
    
    .hero-section:before {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      width: 40%;
      height: 100%;
      background: url('assets/images/hospital-hero.jpg') no-repeat center right;
      background-size: cover;
      opacity: 0.9;
    }
    
    .hero-content {
      position: relative;
      z-index: 2;
      max-width: 600px;
    }
    
    .hero-title {
      font-family: 'Playfair Display', serif;
      font-size: 2.8rem;
      font-weight: 700;
      color: black;
      margin-bottom: 20px;
    }
    
    .hero-subtitle {
      font-size: 1.2rem;
      color: var(--black);
      margin-bottom: 30px;
    }
    
    /* Main Content */
    .section-title {
      font-family: 'Playfair Display', serif;
      color: var(--deep-purple);
      position: relative;
      margin-bottom: 30px;
    }
    
    .section-title:after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 0;
      width: 60px;
      height: 3px;
      background-color: var(--dark-lavender);
    }
    
    /* Hospital List */
    .hospital-card {
      background-color: var(--white);
      border-radius: 10px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
      margin-bottom: 20px;
      transition: all 0.3s ease;
      border: none;
      overflow: hidden;
      cursor: pointer;
    }
    
    .hospital-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .hospital-card-header {
      background-color: #E3D7ED;
      color: var(--deep-purple);
      font-weight: 600;
      padding: 15px 20px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .hospital-card-body {
      padding: 20px;
    }
    
    .hospital-info {
      margin-bottom: 10px;
    }
    
    .hospital-info i {
      color: var(--dark-lavender);
      width: 20px;
      margin-right: 8px;
    }
    
    .view-details {
      color: var(--deep-purple);
      font-weight: 500;
      text-decoration: none;
      transition: all 0.3s ease;
    }
    
    .view-details:hover {
      color: var(--dark-lavender);
      text-decoration: underline;
    }
    
    /* Tips Section */
    .tips-section {
      background-color: var(--light-gray);
      padding: 60px 0;
      margin: 60px 0;
    }
    
    .tips-image-container {
      position: relative;
      overflow: hidden;
      height: 100%;
      min-height: 300px;
    }
    
    .tips-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }
    
    .tips-image-container:hover .tips-image {
      transform: scale(1.05);
    }
    
    .accordion-item {
      margin-bottom: 15px;
      border-radius: 8px !important;
      overflow: hidden;
      border: 1px solid rgba(0, 0, 0, 0.1) !important;
    }
    
    .accordion-button {
      background-color: var(--white);
      color: var(--black);
      font-weight: 600;
      padding: 15px 20px;
    }
    
    .accordion-button:not(.collapsed) {
      background-color: var(--lavender);
      color: var(--deep-purple);
    }
    
    .accordion-button:focus {
      box-shadow: none;
      border-color: var(--lavender);
    }
    
    .accordion-body {
      padding: 20px;
      background-color: var(--white);
    }
    
    /* Modal */
    .modal-content {
      border-radius: 10px;
      border: none;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }
    
    .modal-header {
      background-color: #E3D7ED;
      color: var(--deep-purple);
      border-bottom: none;
      padding: 20px;
    }
    
    .modal-title {
      font-weight: 700;
    }
    
    .modal-body {
      padding: 25px;
    }
    
    .modal-footer {
      border-top: none;
      padding: 15px 25px;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 992px) {
      .hero-section:before {
        width: 100%;
        opacity: 0.3;
      }
      
      .hero-content {
        max-width: 100%;
        text-align: center;
      }
      
      .hero-title {
        font-size: 2.2rem;
      }
    }
    
    @media (max-width: 768px) {
      .hero-section {
        padding: 80px 0 60px;
      }
      
      .hero-title {
        font-size: 1.8rem;
      }
    }
  </style>
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
          <a class="nav-link active" href="index.php">Home</a>
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
         <li class="nav-item ms-lg-3">
              <a class="nav-link btn-adopt" href="#">Add pet</a>
            </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
  <div class="container">
    <div class="hero-content">
      <h1 class="hero-title">Pet Hospitals Near You</h1>
      <p class="hero-subtitle">Find the best veterinary care for your furry friends</p>
      <a href="#hospitals" class="btn btn-primary">Explore Hospitals</a>
    </div>
  </div>
</section>

<!-- Main Content -->
<div class="container" id="hospitals">
  <div class="row">
    <div class="col-lg-8">
      <h2 class="section-title">Nearby Pet Hospitals</h2>
      
      <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <div class="col-md-6">
            <div class="hospital-card" data-bs-toggle="modal" data-bs-target="#hospitalModal" onclick='setModalData(<?php echo json_encode($row); ?>)'>
              <div class="hospital-card-header">
                <i class="fas fa-hospital me-2"></i><?php echo htmlspecialchars($row['name']); ?>
              </div>
              <div class="hospital-card-body">
                <div class="hospital-info">
                  <i class="fas fa-map-marker-alt"></i>
                  <span><?php echo htmlspecialchars($row['location']); ?></span>
                </div>
                <div class="hospital-info">
                  <i class="fas fa-phone"></i>
                  <span><?php echo htmlspecialchars($row['contact']); ?></span>
                </div>
                <div class="hospital-info">
                  <i class="fas fa-stethoscope"></i>
                  <span><?php echo htmlspecialchars($row['services']); ?></span>
                </div>
                <div class="text-end mt-3">
                  <a href="#" class="view-details">View Details <i class="fas fa-chevron-right ms-1"></i></a>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
    
    <div class="col-lg-4">
      <div class="p-4 rounded-3" style="background-color: #E3D7ED;">
        <h3 class="mb-4" style="color: var(--deep-purple);">Emergency Contacts</h3>
        <div class="mb-4">
          <h5 class="d-flex align-items-center" style="color: var(--deep-purple);">
            <i class="fas fa-phone-alt me-3"></i>24/7 Emergency
          </h5>
          <p class="ms-5">123-456-7890</p>
        </div>
        <div class="mb-4">
          <h5 class="d-flex align-items-center" style="color: var(--deep-purple);">
            <i class="fas fa-ambulance me-3"></i>Pet Ambulance
          </h5>
          <p class="ms-5">987-654-3210</p>
        </div>
        <div class="mb-4">
          <h5 class="d-flex align-items-center" style="color: var(--deep-purple);">
            <i class="fas fa-info-circle me-3"></i>Poison Control
          </h5>
          <p class="ms-5">555-123-4567</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Tips Section -->
<section class="tips-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-5 mb-4 mb-lg-0">
        <div class="tips-image-container">
          <img src="assets/images/Hospital.png" alt="Pet care tips" class="tips-image">
        </div>
      </div>
      <div class="col-lg-7">
        <h2 class="section-title">Essential Pet Care Tips</h2>
        
        <div class="accordion" id="careTipsAccordion">
          <div class="accordion-item">
            <h3 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-bone me-3"></i> Nutrition & Diet
              </button>
            </h3>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#careTipsAccordion">
              <div class="accordion-body">
                <p>Provide a balanced diet appropriate for your pet's age, breed, and health status. Always have fresh water available. Avoid feeding pets human food that can be toxic like chocolate, grapes, onions, and xylitol-containing products.</p>
                <ul class="mt-3">
                  <li>Feed high-quality commercial pet food</li>
                  <li>Follow recommended portion sizes</li>
                  <li>Establish a regular feeding schedule</li>
                </ul>
              </div>
            </div>
          </div>
          
          <div class="accordion-item">
            <h3 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <i class="fas fa-home me-3"></i> Safe Environment
              </button>
            </h3>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#careTipsAccordion">
              <div class="accordion-body">
                <p>Create a safe, comfortable space for your pet with appropriate bedding, shelter, and protection from hazards. Pet-proof your home by securing electrical cords, toxic substances, and small objects they might swallow.</p>
              </div>
            </div>
          </div>
          
          <div class="accordion-item">
            <h3 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <i class="fas fa-heartbeat me-3"></i> Regular Checkups
              </button>
            </h3>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#careTipsAccordion">
              <div class="accordion-body">
                <p>Schedule annual wellness exams and stay current with vaccinations and parasite prevention. Dental care is also crucial - brush your pet's teeth regularly or use veterinary-approved dental treats.</p>
              </div>
            </div>
          </div>
          
          <div class="accordion-item">
            <h3 class="accordion-header" id="headingFour">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                <i class="fas fa-running me-3"></i> Exercise & Play
              </button>
            </h3>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#careTipsAccordion">
              <div class="accordion-body">
                <p>Provide daily physical activity and mental stimulation appropriate for your pet's species, breed, and age. Regular exercise helps prevent obesity and behavioral problems.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Hospital Modal -->
<div class="modal fade" id="hospitalModal" tabindex="-1" aria-labelledby="hospitalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="hospitalModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="hospitalModalBody">
        <!-- Content will be inserted here by JavaScript -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="getDirectionsBtn">Get Directions</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Navbar scroll effect
  window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });
  
  // Current hospital data
  let currentHospital = null;
  
  // Modal functionality
  function setModalData(hospital) {
    currentHospital = hospital;
    
    document.getElementById('hospitalModalLabel').innerHTML = 
      `<i class="fas fa-hospital me-2"></i>${hospital.name}`;
    
    document.getElementById('hospitalModalBody').innerHTML = 
      `<div class="mb-3">
        <h6 class="d-flex align-items-center">
          <i class="fas fa-map-marker-alt me-3" style="color: var(--dark-lavender);"></i>
          <span style="color: var(--deep-purple);">Location</span>
        </h6>
        <p class="ms-5">${hospital.location}</p>
      </div>
      <div class="mb-3">
        <h6 class="d-flex align-items-center">
          <i class="fas fa-phone me-3" style="color: var(--dark-lavender);"></i>
          <span style="color: var(--deep-purple);">Contact</span>
        </h6>
        <p class="ms-5">${hospital.contact}</p>
      </div>
      
      <div class="mb-3">
        <h6 class="d-flex align-items-center">
          <i class="fas fa-stethoscope me-3" style="color: var(--dark-lavender);"></i>
          <span style="color: var(--deep-purple);">Services</span>
        </h6>
        <p class="ms-5">${hospital.services}</p>
      </div>
      <div class="mb-3">
        <h6 class="d-flex align-items-center">
          <i class="fas fa-info-circle me-3" style="color: var(--dark-lavender);"></i>
          <span style="color: var(--deep-purple);">About</span>
        </h6>
        <p class="ms-5">${hospital.about || 'No additional information available.'}</p>
      </div>`;
  }
  
  // Get Directions button handler
  document.getElementById('getDirectionsBtn').addEventListener('click', function() {
    if (currentHospital && currentHospital.location) {
      const address = encodeURIComponent(currentHospital.location);
      window.open(`https://www.google.com/maps/dir/?api=1&destination=${address}`, '_blank');
    }
  });
</script>
</body>
</html>