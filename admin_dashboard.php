
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Adoption Home</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
     <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />

    

    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />

    <!-- Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Poppins&display=swap"
      rel="stylesheet"
    />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/admin_dashboard.css" />
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Stray Heart</a>

        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav w-100 d-flex justify-content-center">
            <li class="nav-item">
              <a class="nav-link active" href="index.html">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pet_list.php">Pet List</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="hospital.php">Hospital List</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="donation.php">Donation</a>
            </li>
            <li class="nav-item ms-lg-3">
          <a class="nav-link btn-adopt" href="add-pet.php" id="addPetBtn">Add Pet</a>
        </li>
            
          </ul>
        </div>
      </div>
    </nav>
   
</head>
<body>

    <div class="container">
        <h1>Adopt Your Best Friend</h1>
        <p>
            Discover loving pets waiting for their forever homes. Start your journey of joy and companionship by adopting a furry friend today!
        </p>
        <div class="button-container">
            <button class="button view-pets" onclick="location.href='manage-pets.php'">Manage pets</button>
            <button class="button add-pet" onclick="location.href='admin_hospital_list.php'">Manage Hospital</button>
            <button class="button add-pet" onclick="location.href='admin-adoption.php'">Manage adoption</button>
            
        </div>
        <div class="image-container">
            <img src="assets/images/home.png">
        </div>
    </div>
</body>
</html>
