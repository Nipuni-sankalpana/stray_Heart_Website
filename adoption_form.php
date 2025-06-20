<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Please log in first.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("INSERT INTO adoptions (user_id, pet_id, fullname, phone, address, note) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("iissss", $_SESSION['user_id'], $_POST['pet_id'], $_POST['fullname'], $_POST['phone'], $_POST['address'], $_POST['note']);
    $stmt->execute();

    if ($stmt->error) {
        die("Execute failed: " . $stmt->error);
    } else {
        echo "<script>alert('Adoption request sent! Thank you for giving a pet a loving home.');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Adopt a Pet</title>
    <link rel="stylesheet" href="assets/css/adoption_form.css">
    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
   
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />


    <style>
        body {
             font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-image: url(assets/images/adoption.jpg);
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        

.navbar {
  background-color: #E3D7ED !important;
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



        .form-container {
            background: transparent;
            border-radius: 15px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2),
                        0 3px 10px rgba(0, 0, 0, 0.1),
                        inset 0 0 10px rgba(255, 255, 255, 0.3);
            width: 400px;
            padding: 25px;
            position: relative;
            overflow: hidden;
        }

        .form-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background:transparent;
            z-index: -1;
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(5px, 5px); }
        }

        h2 {
            text-align: center;
            color: black;
            text-shadow: 0 2px 3px rgba(0,0,0,0.2);
            font-size: 24px;
            margin-bottom: 20px;
            position: relative;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            color: black;
            margin-bottom: 5px;
            font-weight: bold;
            text-shadow: 0 1px 1px rgba(0,0,0,0.2);
            font-size: 14px;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px 12px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            background: transparent;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        textarea {
            min-height: 60px;
        }

        input:focus,
        textarea:focus,
        select:focus {
            background: #E3D7ED;
            outline: none;
            box-shadow: 0 2px 10px rgba(255, 255, 255, 0.4);
        }

        button {
            background: #E3D7ED;
            background-size: 200% 200%;
            color: black;
            padding: 12px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            transition: all 0.4s ease;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            margin-top: 5px;
        }

        button:hover {
            background-position: 100% 100%;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .message-box {
            margin-top: 15px;
            padding: 12px;
            background: transparent;
            border-left: 3px solid #fad0c4;
            color: black;
            border-radius: 6px;
            text-shadow: 0 1px 1px rgba(0,0,0,0.1);
            font-size: 13px;
        }

        select option {
            background: rgba(255, 255, 255, 0.9);
            color: #333;
        }

        /* Smaller paw prints decoration */
        .paw {
            position: absolute;
            width: 15px;
            height: 15px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            z-index: -1;
        }

        .paw::before,
        .paw::after {
            content: '';
            position: absolute;
            width: 7px;
            height: 7px;
            background: inherit;
            border-radius: 50%;
        }

        .paw-1 { top: 8%; left: 12%; }
        .paw-2 { bottom: 12%; right: 8%; }
        .paw-3 { top: 25%; right: 15%; }
    
  
    </style>
    
</head>
<body>
<!-- Bootstrap Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">
      <span style="color: black">Stray</span> <span style="color:#5A3D7A;">Heart</span>
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

<div class="form-container">
   
    <div class="paw paw-1"></div>
    <div class="paw paw-2"></div>
    <div class="paw paw-3"></div>
    
    <h2>Adoption Request Form</h2>
    <form method="POST">
        <div class="form-group">
            <label for="pet_id">Choose Pet:</label>
            <select name="pet_id" id="pet_id" required>
                <option value="">-- Select Pet --</option>
                <?php
                $pets = $conn->query("SELECT id, name FROM pets");
                while ($pet = $pets->fetch_assoc()) {
                    echo "<option value='{$pet['id']}'>{$pet['name']} (ID: {$pet['id']})</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="fullname">Full Name:</label>
            <input type="text" name="fullname" id="fullname" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" required>
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <textarea name="address" id="address" required></textarea>
        </div>


        <button type="submit">Send Adoption Request</button>
    </form>

    <div class="message-box">
        <strong>❤️ Reminder:</strong> Adopting a pet is a lifetime commitment. Please ensure you can provide a safe, loving home.
    </div>
</div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>