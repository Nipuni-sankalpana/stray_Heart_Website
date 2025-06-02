<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
include 'db.php';

// Fetch all pets
$pets = $conn->query("SELECT * FROM pets");

// Get unique species for dropdown
$species_result = $conn->query("SELECT DISTINCT species FROM pets");
$species = [];
while($row = $species_result->fetch_assoc()) {
    $species[] = $row['species'];
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <title>Available Pets</title>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="assets/js/script.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Poppins&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/petlist.css">
    <style>
      #notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #28a745;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        display: none;
        z-index: 9999;
      }
    </style>
  </head>
  
  <body>
    <div id="notification"></div>

    <!-- Bootstrap Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
      <div class="container">
        <a class="navbar-brand" href="#">
          <span style="color: #e3d7ed">Stray</span> <span style="color:black">Heart</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="pet_list.php">Pet List</a></li>
            <li class="nav-item"><a class="nav-link" href="hospital.php">Hospitals</a></li>
            <li class="nav-item"><a class="nav-link" href="donate.php">Donation</a></li>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
              <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Admin</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION['user_id'])): ?>
              <li class="nav-item dropdown ms-lg-3">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                  <i class="fas fa-user-circle fa-lg"></i> 
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item" href="profile.php">View Profile</a></li>
                  <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
              </li>
            <?php else: ?>
              <li class="nav-item ms-lg-2">
                <a class="nav-link btn-adopt" href="login.php">Login</a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>

    <div class="hero">
      <div class="overlay">
        <h1>Welcome to Pet List 🐶🐱</h1>
        <p>Rescue. Love. Repeat. Find your perfect furry friend today!</p>
      </div>
    </div>

    <div class="search-container">
      <div class="input-group">
        <input type="text" id="petSearch" class="search-box" placeholder="Search pets by name, breed or description...">
        <button class="search-btn" id="searchButton"><i class="fas fa-search"></i></button>
      </div>
      <div class="filter-dropdown">
        <button class="filter-btn active" data-species="all">All Pets</button>
        <?php foreach($species as $spec): ?>
          <button class="filter-btn" data-species="<?= htmlspecialchars(strtolower($spec)) ?>">
            <?= htmlspecialchars($spec) ?>s
          </button>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="no-results" id="noResults">
      <i class="fas fa-paw fa-3x" style="margin-bottom: 15px;"></i>
      <h3>No pets found matching your search</h3>
      <p>Try adjusting your search or filter criteria</p>
    </div>

    <div class="pet-container" id="petContainer">
      <?php while($row = $pets->fetch_assoc()): ?>
        <div class="pet-card" data-id="<?= $row['id'] ?>" data-species="<?= strtolower($row['species']) ?>">
          <?php
          $likes_result = $conn->query("SELECT COUNT(*) AS total FROM likes WHERE pet_id=" . $row['id']);
          $likes = $likes_result->fetch_assoc()['total'];
          ?>
          <button class="like-btn" onclick="likePet(<?= $row['id'] ?>)">❤️</button>
          <img src="uploads/pets/<?= $row['image'] ?>" alt="<?= $row['name'] ?>">
          <h3><?= htmlspecialchars($row['name']) ?></h3>
          <p><strong>Breed:</strong> <?= htmlspecialchars($row['breed']) ?></p>
          <p><strong>Species:</strong> <?= htmlspecialchars($row['species']) ?></p>
          <p><strong>Age:</strong> <?= htmlspecialchars($row['age']) ?> years</p>
          <p><?= htmlspecialchars($row['description']) ?></p>
          <p>❤️ Likes: <?= $likes ?></p>
          <button class="btn" onclick="window.location.href='adoption_form.php?pet_id=<?= $row['id'] ?>'">Adopt</button>
        </div>
      <?php endwhile; ?>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function showNotification(message, isError = false) {
      const notify = document.getElementById('notification');
      notify.textContent = message;
      notify.style.background = isError ? '#dc3545' : '#28a745';
      notify.style.display = 'block';
      setTimeout(() => {
        notify.style.display = 'none';
        location.reload();
      }, 1500);
    }

    function likePet(petId) {
      fetch('like_pet.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'pet_id=' + petId
      })
      .then(res => res.text())
      .then(data => {
        if (data === 'Liked') {
          showNotification("❤️ You liked this pet!");
        } else if (data === 'Already liked') {
          showNotification("❗ You already liked this pet!", true);
        } else {
          showNotification(data, true);
        }
      });
    }

    // Search & Filter
    document.addEventListener('DOMContentLoaded', () => {
      const searchInput = document.getElementById('petSearch');
      const searchButton = document.getElementById('searchButton');
      const filterButtons = document.querySelectorAll('.filter-btn');
      const petCards = document.querySelectorAll('.pet-card');
      const petContainer = document.getElementById('petContainer');
      const noResults = document.getElementById('noResults');

      function performSearch() {
        const searchTerm = searchInput.value.toLowerCase();
        const activeFilter = document.querySelector('.filter-btn.active').dataset.species;
        let hasResults = false;

        petCards.forEach(card => {
          const petName = card.querySelector('h3').textContent.toLowerCase();
          const petBreed = card.querySelector('p:nth-of-type(1)').textContent.toLowerCase();
          const petDesc = card.querySelector('p:nth-of-type(4)').textContent.toLowerCase();
          const petSpecies = card.dataset.species;

          const matchesSearch = petName.includes(searchTerm) || petBreed.includes(searchTerm) || petDesc.includes(searchTerm);
          const matchesFilter = activeFilter === 'all' || petSpecies === activeFilter;

          if (matchesSearch && matchesFilter) {
            card.style.display = 'block';
            hasResults = true;
          } else {
            card.style.display = 'none';
          }
        });

        noResults.style.display = hasResults ? 'none' : 'block';
        petContainer.style.display = hasResults ? 'flex' : 'none';
      }

      searchInput.addEventListener('input', performSearch);
      searchButton.addEventListener('click', performSearch);

      filterButtons.forEach(button => {
        button.addEventListener('click', function() {
          filterButtons.forEach(btn => btn.classList.remove('active'));
          this.classList.add('active');
          performSearch();
        });
      });
    });
    </script>
  </body>
</html>
