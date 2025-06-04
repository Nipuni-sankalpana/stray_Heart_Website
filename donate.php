<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';

// Fetch latest pet stall info
$stall_address = 'Not available';
$stall_schedule = 'Not available';
$result = $conn->query("SELECT * FROM pet_stall_info ORDER BY updated_at DESC LIMIT 1");
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $stall_address = $row['address'] ?? 'Not available';
    $stall_schedule = $row['schedule'] ?? 'Not available';
}

// Fetch admin home address for food donations
$admin_address = 'Not available';
$result = $conn->query("SELECT home_address FROM admin_settings LIMIT 1");
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $admin_address = $row['home_address'] ?? 'Not available';
}

// Handle donation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['donation_type'])) {
    $type = $_POST['donation_type'];
    
    try {
        if ($type === 'money') {
            $amount = floatval($_POST['amount']);
            $payment_method = $_POST['payment_method'];
            
            if ($amount <= 0) {
                throw new Exception("Amount must be greater than 0");
            }
            
            $stmt = $conn->prepare("INSERT INTO money_donations (user_id, amount, payment_method) VALUES (?, ?, ?)");
            $stmt->bind_param("ids", $user_id, $amount, $payment_method);
            if ($stmt->execute()) {
                $message = "Money donation successful. Thank you!";
            } else {
                throw new Exception("Error processing money donation");
            }

        } elseif ($type === 'food') {
            $food_type = trim($_POST['food_type']);
            $quantity = floatval($_POST['food_quantity']);
            $msg = trim($_POST['food_message'] ?? '');
            
            if (empty($food_type)) {
                throw new Exception("Food type is required");
            }
            if ($quantity <= 0) {
                throw new Exception("Quantity must be greater than 0");
            }
            
            $stmt = $conn->prepare("INSERT INTO food_donations (user_id, food_type, quantity, message) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isds", $user_id, $food_type, $quantity, $msg);
            if ($stmt->execute()) {
                $message = "Food donation request sent. You can deliver to our admin's address below.";
            } else {
                throw new Exception("Error processing food donation");
            }

        } elseif ($type === 'item') {
            $item_name = trim($_POST['item_name']);
            $quantity = intval($_POST['item_quantity']);
            $msg = trim($_POST['item_message'] ?? '');
            
            if (empty($item_name)) {
                throw new Exception("Item name is required");
            }
            if ($quantity <= 0) {
                throw new Exception("Quantity must be greater than 0");
            }
            
            $stmt = $conn->prepare("INSERT INTO item_donations (user_id, item_name, quantity, message) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isis", $user_id, $item_name, $quantity, $msg);
            if ($stmt->execute()) {
                $message = "Item donation request sent. Waiting for admin confirmation.";
            } else {
                throw new Exception("Error processing item donation");
            }
        }
    } catch (Exception $e) {
        $message = $e->getMessage();
    }
}
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
            background-color:  #E3D7ED!important;
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
            color: black;
            font-size: 2.8rem;
            margin-bottom: 20px;
        }
        
        .hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 30px;
        }
        
        .btn-primary {
            background-color: #E3D7ED;
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 50px;
            transition: all 0.3s;
            color: black;
        }
        
        .btn-primary:hover {
            background-color: black;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(138, 79, 255, 0.3);
            color: #E3D7ED;
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
            color: black;
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
            color: #D1C4E9;
            margin-bottom: 15px;
        }
        
        .info-card h3 {
            color: black;
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
            background-color: #E3D7ED;
            color: black;
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
            background-color: black;
            color: #E3D7ED;
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
        
        .message {
            margin: 20px 0;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .message.success {
            background-color: #d8f3dc;
            color: #2b8a3e;
        }

        .message.error {
            background-color: #ffebee;
            color: #c62828;
        }
        
        .payment-icon {
            height: 30px;
            margin-right: 10px;
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
    <a class="navbar-brand" href="index.php">
      <span style="color: white">Stray</span> <span style="color:black">Heart</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="pet_list.php">Pet List</a></li>
        <li class="nav-item"><a class="nav-link" href="hospital.php">Hospitals</a></li>
        <li class="nav-item"><a class="nav-link active" href="donate.php">Donation</a></li>

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

<div class="container">
    <?php if ($message): ?>
        <div class="message <?= strpos($message, 'Error') === false ? 'success' : 'error' ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <!-- Donation Form -->
    <div class="donation-form" id="donation-form">
        <h2 class="form-title">Donation Information</h2>
        <form method="POST" action="">
            <label for="donation_type">I want to donate:</label>
            <select id="donation_type" name="donation_type" onchange="showFields()" required>
                <option value="">-- Select donation type --</option>
                <option value="money" <?= isset($_POST['donation_type']) && $_POST['donation_type'] === 'money' ? 'selected' : '' ?>>Money</option>
                <option value="food" <?= isset($_POST['donation_type']) && $_POST['donation_type'] === 'food' ? 'selected' : '' ?>>Pet Food</option>
                <option value="item" <?= isset($_POST['donation_type']) && $_POST['donation_type'] === 'item' ? 'selected' : '' ?>>Supplies/Items</option>
            </select>

            <!-- Money Donation Fields -->
            <div id="money_fields">
                <label>Donation Amount (LKR):</label>
                <input type="number" name="amount" min="1" step="0.01" 
                       value="<?= isset($_POST['amount']) ? htmlspecialchars($_POST['amount']) : '' ?>" required>

                <label>Payment Method:</label>
                <select name="payment_method" id="payment_method" onchange="togglePaymentFields()" required>
                    <option value="">-- Select payment method --</option>
                    <option value="Online" <?= isset($_POST['payment_method']) && $_POST['payment_method'] === 'Online' ? 'selected' : '' ?>>Online</option>
                    <option value="Physical" <?= isset($_POST['payment_method']) && $_POST['payment_method'] === 'Physical' ? 'selected' : '' ?>>Physical</option>
                </select>

                <div id="online_payment_fields" style="display:none; margin-top:15px;">
                    <label>Cardholder Name:</label>
                    <input type="text" placeholder="e.g., John Doe" required>

                    <label>Card Number:</label>
                    <input type="text" maxlength="19" placeholder="xxxx xxxx xxxx xxxx" 
                           oninput="formatCardNumber(this)" required>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Expiry Date:</label>
                            <input type="text" placeholder="MM/YY" oninput="formatExpiryDate(this)" required>
                        </div>
                        <div class="col-md-6">
                            <label>CVV:</label>
                            <input type="password" maxlength="4" placeholder="123" required>
                        </div>
                    </div>

                    <div style="margin-top:10px;">
                        <img src="https://img.icons8.com/color/48/visa.png" alt="Visa" class="payment-icon">
                        <img src="https://img.icons8.com/color/48/mastercard.png" alt="Mastercard" class="payment-icon">
                        <img src="https://img.icons8.com/color/48/amex.png" alt="American Express" class="payment-icon">
                    </div>
                </div>
            </div>

            <!-- Food Donation Fields -->
            <div id="food_fields">
                <label>Food Type:</label>
                <input type="text" name="food_type" 
                       value="<?= isset($_POST['food_type']) ? htmlspecialchars($_POST['food_type']) : '' ?>" required>

                <label>Quantity (kg):</label>
                <input type="number" name="food_quantity" min="1" step="0.01" 
                       value="<?= isset($_POST['food_quantity']) ? htmlspecialchars($_POST['food_quantity']) : '' ?>" required>

                <label>Message (optional):</label>
                <textarea name="food_message" rows="3"><?= isset($_POST['food_message']) ? htmlspecialchars($_POST['food_message']) : '' ?></textarea>
            </div>

            <!-- Item Donation Fields -->
            <div id="item_fields">
                <label>Item Name:</label>
                <input type="text" name="item_name" 
                       value="<?= isset($_POST['item_name']) ? htmlspecialchars($_POST['item_name']) : '' ?>" required>

                <label>Quantity:</label>
                <input type="number" name="item_quantity" min="1" 
                       value="<?= isset($_POST['item_quantity']) ? htmlspecialchars($_POST['item_quantity']) : '' ?>" required>

                <label>Message (optional):</label>
                <textarea name="item_message" rows="3"><?= isset($_POST['item_message']) ? htmlspecialchars($_POST['item_message']) : '' ?></textarea>
            </div>

            <button type="submit" class="donate-btn">Donate</button>
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
    function showFields() {
        var type = document.getElementById('donation_type').value;
        document.getElementById('money_fields').style.display = (type === 'money') ? 'block' : 'none';
        document.getElementById('food_fields').style.display = (type === 'food') ? 'block' : 'none';
        document.getElementById('item_fields').style.display = (type === 'item') ? 'block' : 'none';
        
        // Reset required fields when switching types
        if (type !== 'money') {
            document.querySelectorAll('#money_fields [required]').forEach(el => el.removeAttribute('required'));
        }
        if (type !== 'food') {
            document.querySelectorAll('#food_fields [required]').forEach(el => el.removeAttribute('required'));
        }
        if (type !== 'item') {
            document.querySelectorAll('#item_fields [required]').forEach(el => el.removeAttribute('required'));
        }
    }

    function togglePaymentFields() {
        var method = document.getElementById('payment_method').value;
        document.getElementById('online_payment_fields').style.display = (method === 'Online') ? 'block' : 'none';
        
        // Toggle required fields
        if (method === 'Online') {
            document.querySelectorAll('#online_payment_fields input').forEach(el => el.setAttribute('required', ''));
        } else {
            document.querySelectorAll('#online_payment_fields input').forEach(el => el.removeAttribute('required'));
        }
    }
    
    function formatCardNumber(input) {
        // Remove all non-digit characters
        let value = input.value.replace(/\D/g, '');
        
        // Add space after every 4 digits
        value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
        
        // Update the input value
        input.value = value.substring(0, 19); // Limit to 16 digits + 3 spaces
    }
    
    function formatExpiryDate(input) {
        let value = input.value.replace(/\D/g, '');
        
        if (value.length > 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        
        input.value = value.substring(0, 5);
    }
    
    // Initialize form fields on page load
    document.addEventListener('DOMContentLoaded', function() {
        showFields();
    });
</script>

</body>
</html>