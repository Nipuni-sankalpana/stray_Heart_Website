<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
include 'db.php';


$search = isset($_GET['search']) ? $_GET['search'] : '';
$location_filter = isset($_GET['location']) ? $_GET['location'] : '';


$query = "SELECT * FROM hospitals WHERE 1=1";


if (!empty($search)) {
    $query .= " AND (name LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' 
              OR services LIKE '%" . mysqli_real_escape_string($conn, $search) . "%')";
}


if (!empty($location_filter)) {
    $query .= " AND location LIKE '%" . mysqli_real_escape_string($conn, $location_filter) . "%'";
}


$query .= " ORDER BY id DESC";

$result = mysqli_query($conn, $query);


$locations_query = "SELECT DISTINCT location FROM hospitals ORDER BY location";
$locations_result = mysqli_query($conn, $locations_query);
$locations = [];
while ($row = mysqli_fetch_assoc($locations_result)) {
    $locations[] = $row['location'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Hospital List </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"/>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
 
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/hospital.css">
  <style>
     body {
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}


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
  background-color: black;
  color: #E3D7ED !important;
  border-radius: 50px;
  padding: 8px 20px !important;
  font-weight: 600;
}

.btn-adopt:hover {
  background-color: #d0c4dd;
  transform: translateY(-2px);
}

.search-filter-container {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.search-filter-container .row {
    align-items: center;
}

.filter-label {
    font-weight: 600;
    margin-right: 10px;
    color: #495057;
}

  
  .hero-section {
    position: relative;
    height: 400px; 
    color: black;
    display: flex;
    align-items: center; 
    justify-content: center; 
    text-align: center; 
    padding: 0 20px;
    margin-top: 56px; 
    
  }

  .hero-content {
    max-width: 1200px;
    width: 100%;
  }

  .hero-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    
  }

  .hero-subtitle {
    font-size: 1.5rem;
    margin-bottom: 2rem;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
  }
  .btn-primary:hover{
  background-color: #1A1A1A;
  color: white;
}
.section-title{
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}



  </style>
</head>

  
<body>
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#"><span style="color: black;">Stray</span> <span style="color:#5A3D7A;">Heart</span></a>
        <button class="navbar-toggler bg-black" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
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



<section class="hero-section">
  <div class="container">
    <div class="hero-content">
      <h1 class="hero-title">Pet Hospitals Near You</h1>
      <p class="hero-subtitle">Find the best veterinary care for your furry friends</p>
      <a href="#hospitals" class="btn btn-primary">Explore Hospitals</a>
    </div>
  </div>
</section>


<div class="container" id="hospitals">
 
  <div class="search-filter-container">
    <form method="GET" action="">
      <div class="row">
        <div class="col-md-6 mb-3 mb-md-0">
          <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search hospitals..." value="<?php echo htmlspecialchars($search); ?>">
            <button class="btn btn-primary" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row align-items-center">
            <div class="col-md-4">
              <span class="filter-label">Filter by:</span>
            </div>
            <div class="col-md-8">
              <select class="form-select" name="location" onchange="this.form.submit()">
                <option value="">All Locations</option>
                <?php foreach ($locations as $loc): ?>
                  <option value="<?php echo htmlspecialchars($loc); ?>" <?php echo ($location_filter == $loc) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($loc); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  
  <div class="row">
    <div class="col-lg-8">
      <h2 class="section-title">Nearby Pet Hospitals</h2>
      
      <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="row">
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-6 mb-4">
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
      <?php else: ?>
        <div class="alert alert-info">
          No hospitals found matching your criteria.
        </div>
      <?php endif; ?>
    </div>
    
    <div class="col-lg-4">
      <div class="p-4 rounded-3" style="background-color: #E3D7ED;">
        <h3 class="mb-4" style="color: var(--deep-purple);">Emergency Contacts</h3>
        <div class="mb-4">
          <h5 class="d-flex align-items-center" style="color: var(--deep-purple);">
            <i class="fas fa-phone-alt me-3"></i>PetVet Clinic-Colombo 5
          </h5>
          <p class="ms-5">0777738838</p>
        </div>
        <div class="mb-4">
          <h5 class="d-flex align-items-center" style="color: var(--deep-purple);">
            <i class="fas fa-phone-alt me-3"></i>Suwana Pet Care-Kalutara
          </h5>
          <p class="ms-5">0776641312</p>
        </div>
        <div class="mb-4">
          <h5 class="d-flex align-items-center" style="color: var(--deep-purple);">
            <i class="fas fa-phone-alt me-3"></i>Blue Paw Veterinary Hospital-Colombo 3
          </h5>
          <p class="ms-5">0774567890</p>
        </div>
       
      </div>
    </div>
  </div>
</div>


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


<div class="modal fade" id="hospitalModal" tabindex="-1" aria-labelledby="hospitalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="hospitalModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="hospitalModalBody">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="getDirectionsBtn">Get Directions</button>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<script>
 
  window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });
  
  
  let currentHospital = null;
  
  
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
  
  
  document.getElementById('getDirectionsBtn').addEventListener('click', function() {
    if (currentHospital && currentHospital.location) {
      const address = encodeURIComponent(currentHospital.location);
      window.open(`https://www.google.com/maps/dir/?api=1&destination=${address}`, '_blank');
    }
  });
</script>
</body>
</html>