<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate to Help Animals</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #8a4fff;
            --light-purple: #f3ebff;
            --white: #ffffff;
            --black: #333333;
            --gray: #f5f5f5;
        }
        
        
        
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--white);
            color: var(--black);
            line-height: 1.6;
            padding-top: 80px; /* To account for fixed navbar */
        }
        /* Navbar customization */
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


        
        .hero {
            background-color: var(--light-purple);
            padding: 80px 20px;
            text-align: center;
            border-radius: 0 0 20px 20px;
            margin-bottom: 40px;
        }
        
        .hero h1 {
            color: var(--primary);
            font-size: 2.8rem;
            margin-bottom: 20px;
        }
        
        .hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 30px;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 50px;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #7b3dff;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(138, 79, 255, 0.3);
        }
        
        .donation-form {
            max-width: 700px;
            margin: 0 auto 50px;
            padding: 30px;
            background: var(--white);
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.05);
            border: 1px solid #eee;
        }
        
        .form-title {
            color: var(--primary);
            text-align: center;
            margin-bottom: 30px;
        }
        
        .info-cards {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 50px;
            flex-wrap: wrap;
        }
        
        .info-card {
            background: var(--white);
            padding: 25px;
            border-radius: 15px;
            width: 300px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border: 1px solid #eee;
            text-align: center;
            transition: transform 0.3s;
        }
        
        .info-card:hover {
            transform: translateY(-5px);
        }
        
        .info-card i {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 15px;
        }
        
        .info-card h3 {
            color: var(--primary);
            margin-bottom: 15px;
        }
        
        .pet-image {
            width: 100%;
            max-width: 500px;
            height: 400px;
            object-fit: cover;
            border-radius: 15px;
            margin: 0 auto 50px;
            display: block;
           
        }
        
        label {
            font-weight: 600;
            margin-top: 15px;
            display: block;
        }
        
        input, select, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-top: 5px;
            font-family: inherit;
        }
        
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(138, 79, 255, 0.2);
        }
        
        .donate-btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 15px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 8px;
            width: 100%;
            margin-top: 20px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .donate-btn:hover {
            background-color: #7b3dff;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(138, 79, 255, 0.3);
        }
        
        #money_fields, #food_fields, #item_fields {
            background-color: var(--light-purple);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            display: none;
        }
        
        @media (max-width: 768px) {
            .hero {
                padding: 60px 15px;
            }
            
            .hero h1 {
                font-size: 2.2rem;
            }
            
            .donation-form {
                padding: 20px;
            }
            
            .pet-image {
                height: 300px;
            }
            
            .navbar-brand {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
 <!-- Bootstrap Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
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
        <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="pet_list.php">Pet List</a></li>
        <li class="nav-item"><a class="nav-link" href="hospital.php">Hospitals</a></li>
        <li class="nav-item"><a class="nav-link" href="donate.php">Donation</a></li>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
          <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Admin</a></li>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_id'])): ?>
          <!-- Profile dropdown -->
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



<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Make a Difference Today</h1>
        <p>Your generous support helps us rescue, rehabilitate and find loving homes for animals in need. Every donation makes a lasting impact.</p>
        <a href="#donation-form" class="btn btn-primary">Donate Now</a>
    </div>
</section>

<!-- Donation Form -->
<div class="container">
    <div class="donation-form" id="donation-form">
        <h2 class="form-title">Donation Information</h2>
        <form>
            <label for="donation_type">I want to donate:</label>
            <select id="donation_type" name="donation_type" required>
                <option value="">-- Select donation type --</option>
                <option value="money">Money</option>
                <option value="food">Pet Food</option>
                <option value="item">Supplies/Items</option>
            </select>

            <!-- Money Donation Fields -->
            <div id="money_fields">
                <label>Donation Amount (LKR):</label>
                <input type="number" name="amount" min="100" step="100" placeholder="1000" required>

                <label>Payment Method:</label>
                <select name="payment_method" id="payment_method" required>
                    <option value="">-- Select payment method --</option>
                    <option value="credit">Credit Card</option>
                    <option value="debit">Debit Card</option>
                    <option value="bank">Bank Transfer</option>
                </select>
            </div>

            <!-- Food Donation Fields -->
            <div id="food_fields">
                <label>Type of Pet Food:</label>
                <input type="text" name="food_type" placeholder="e.g., Dry dog food, Cat treats" required>

                <label>Quantity (kg or items):</label>
                <input type="number" name="food_quantity" min="1" required>

                <label>Special Notes:</label>
                <textarea name="food_notes" rows="3" placeholder="Brand preferences, dietary restrictions, etc."></textarea>
            </div>

            <!-- Item Donation Fields -->
            <div id="item_fields">
                <label>Item Description:</label>
                <input type="text" name="item_name" placeholder="e.g., Pet beds, Leashes, Toys" required>

                <label>Quantity:</label>
                <input type="number" name="item_quantity" min="1" required>

                <label>Condition:</label>
                <select name="item_condition">
                    <option value="new">New</option>
                    <option value="used">Used - Good condition</option>
                    <option value="needs_repair">Needs repair</option>
                </select>
            </div>

            <button type="submit" class="donate-btn">Continue with Donation</button>
        </form>
    </div>

    <!-- Pet Image -->
    <img src="assets/images/image (41).webp" 
         alt="Happy rescued dogs" class="pet-image">

    <!-- Information Cards -->
    <div class="info-cards">
        <div class="info-card">
            <i class="fas fa-map-marker-alt"></i>
            <h3>Our Location</h3>
            <p>B/9 Batupitiya , Atale<br>Kegalle<br>Sri Lanka</p>
        </div>
        
        <div class="info-card">
            <i class="fas fa-clock"></i>
            <h3>Donation Hours</h3>
            <p>Monday-Friday: 8:30am-5:30pm<br>Saturday: 9am-2pm<br>Sunday: Closed</p>
        </div>
        
        <div class="info-card">
            <i class="fas fa-phone-alt"></i>
            <h3>Contact Us</h3>
            <p>0772605610<br>strayheartpet@gmail.com<br>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Form field toggling
    document.getElementById('donation_type').addEventListener('change', function() {
        const type = this.value;
        document.getElementById('money_fields').style.display = (type === 'money') ? 'block' : 'none';
        document.getElementById('food_fields').style.display = (type === 'food') ? 'block' : 'none';
        document.getElementById('item_fields').style.display = (type === 'item') ? 'block' : 'none';
    });

    // Initialize form fields
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('donation_type').dispatchEvent(new Event('change'));
    });
</script>

</body>
</html>