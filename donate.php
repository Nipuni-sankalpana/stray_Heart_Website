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
    <title>Make a Donation</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/donate.css">
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
    </script>
    
</head>
<body onload="showFields()">

<!-- Bootstrap Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <span style="color: #e3d7ed">Stray</span> <span style="color:black">Heart</span>
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

<!-- Add spacing for fixed-top navbar -->
<div style="margin-top: 80px;"></div>

<div class="container">
    <h1>Make a Donation</h1>

    <?php if ($message): ?>
        <div class="message <?= strpos($message, 'Error') === false ? 'success' : 'error' ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="donation_type">Donation Type:</label>
        <select id="donation_type" name="donation_type" onchange="showFields()" required>
            <option value="">-- Select Donation Type --</option>
            <option value="money" <?= isset($_POST['donation_type']) && $_POST['donation_type'] === 'money' ? 'selected' : '' ?>>Money</option>
            <option value="food" <?= isset($_POST['donation_type']) && $_POST['donation_type'] === 'food' ? 'selected' : '' ?>>Food</option>
            <option value="item" <?= isset($_POST['donation_type']) && $_POST['donation_type'] === 'item' ? 'selected' : '' ?>>Item</option>
        </select>

        <!-- MONEY DONATION -->
        <div id="money_fields">
            <label>Amount (LKR):</label>
            <input type="number" name="amount" min="1" step="0.01" 
                   value="<?= isset($_POST['amount']) ? htmlspecialchars($_POST['amount']) : '' ?>" required>

            <label>Payment Method:</label>
            <select name="payment_method" id="payment_method" onchange="togglePaymentFields()" required>
                <option value="">-- Select Payment Method --</option>
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

        <!-- FOOD DONATION -->
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

        <!-- ITEM DONATION -->
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

        <button type="submit">Donate</button>
    </form>

    <div class="stall-info">
        <h2><i class="fas fa-paw"></i> Pet Stall Location & Hours</h2>
        <p><strong><i class="fas fa-map-marker-alt"></i> Address:</strong> <?= htmlspecialchars($stall_address) ?></p>
        <p><strong><i class="fas fa-clock"></i> Schedule:</strong> <?= htmlspecialchars($stall_schedule) ?></p>
    </div>

    <?php if ($admin_address): ?>
    <div class="admin-address">
        <h2><i class="fas fa-home"></i> Admin Home Address (For Food Donations)</h2>
        <p><strong><i class="fas fa-map-marker-alt"></i> Delivery Address:</strong> <?= htmlspecialchars($admin_address) ?></p>
        <p><strong><i class="fas fa-info-circle"></i> Note:</strong> Please contact admin before delivering food donations.</p>
    </div>
    <?php endif; ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Scroll effect for navbar
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>
</body>
</html>