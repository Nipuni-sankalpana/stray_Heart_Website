
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
$stall_address = '';
$stall_schedule = '';
$result = $conn->query("SELECT * FROM pet_stall_info ORDER BY updated_at DESC LIMIT 1");
if ($result && $row = $result->fetch_assoc()) {
    $stall_address = $row['address'];
    $stall_schedule = $row['schedule'];
}

// Handle donation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['donation_type'];

    if ($type === 'money') {
        $amount = floatval($_POST['amount']);
        $payment_method = $_POST['payment_method'];
        $stmt = $conn->prepare("INSERT INTO money_donations (user_id, amount, payment_method) VALUES (?, ?, ?)");
        $stmt->bind_param("ids", $user_id, $amount, $payment_method);
        $message = $stmt->execute() ? "Money donation successful. Thank you!" : "Error processing donation.";

    } elseif ($type === 'food') {
        $food_type = $_POST['food_type'];
        $quantity = floatval($_POST['food_quantity']);
        $msg = $_POST['food_message'];
        $stmt = $conn->prepare("INSERT INTO food_donations (user_id, food_type, quantity, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isds", $user_id, $food_type, $quantity, $msg);
        $message = $stmt->execute() ? "Food donation request sent. Waiting for admin confirmation." : "Error processing donation.";

    } elseif ($type === 'item') {
        $item_name = $_POST['item_name'];
        $quantity = intval($_POST['item_quantity']);
        $msg = $_POST['item_message'];
        $stmt = $conn->prepare("INSERT INTO item_donations (user_id, item_name, quantity, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isis", $user_id, $item_name, $quantity, $msg);
        $message = $stmt->execute() ? "Item donation request sent. Waiting for admin confirmation." : "Error processing donation.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Make a Donation</title>
    <script>
        function showFields() {
            var type = document.getElementById('donation_type').value;
            document.getElementById('money_fields').style.display = (type === 'money') ? 'block' : 'none';
            document.getElementById('food_fields').style.display = (type === 'food') ? 'block' : 'none';
            document.getElementById('item_fields').style.display = (type === 'item') ? 'block' : 'none';
        }
    </script>
    <style>
        :root {
            --lavender: #e6e6fa;
            --soft-lavender: #f0e6fa;
            --dark-lavender: #9370db;
            --white: #ffffff;
            --black: #333333;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            max-width: 900px;
            margin: auto;
            padding: 30px;
            background-color: var(--soft-lavender);
            color: var(--black);
        }

        h1, h2 {
            color: var(--dark-lavender);
            text-align: center;
        }

        form {
            background-color: var(--white);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        label {
            margin-top: 15px;
            display: block;
            font-weight: 500;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            margin-top: 20px;
            padding: 12px;
            background: var(--dark-lavender);
            color: var(--white);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
        }

        .message {
            margin: 20px 0;
            padding: 15px;
            background-color: #d8f3dc;
            color: #2b8a3e;
            border-radius: 5px;
            text-align: center;
        }

        #money_fields, #food_fields, #item_fields {
            margin-top: 15px;
            background-color: var(--lavender);
            padding: 15px;
            border-radius: 5px;
        }

        .donation-section {
            display: flex;
            gap: 20px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .donation-box {
            flex: 1;
            min-width: 300px;
            padding: 20px;
            border-radius: 10px;
            background: var(--white);
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .stall-info {
            margin-top: 40px;
            padding: 20px;
            background: var(--white);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        @media (max-width: 768px) {
            body { padding: 15px; }
        }
    </style>
</head>
<body onload="showFields()">

<h1>Make a Donation</h1>

<?php if ($message) echo "<div class='message'>$message</div>"; ?>

<form method="POST" action="">
    <label for="donation_type">Donation Type:</label>
    <select id="donation_type" name="donation_type" onchange="showFields()" required>
        <option value="">-- Select Donation Type --</option>
        <option value="money">Money</option>
        <option value="food">Food</option>
        <option value="item">Item</option>
    </select>

    <div id="money_fields" style="display:none;">
        <label>Amount (LKR):</label>
        <input type="number" name="amount" min="1" step="0.01">
        <label>Payment Method:</label>
        <select name="payment_method">
            <option value="">-- Select Payment Method --</option>
            <option value="Online">Online</option>
            <option value="Physical">Physical</option>
        </select>
    </div>

    <div id="food_fields" style="display:none;">
        <label>Food Type:</label>
        <input type="text" name="food_type">
        <label>Quantity (kg):</label>
        <input type="number" name="food_quantity" min="1" step="0.01">
        <label>Message (optional):</label>
        <textarea name="food_message" rows="3"></textarea>
    </div>

    <div id="item_fields" style="display:none;">
        <label>Item Name:</label>
        <input type="text" name="item_name">
        <label>Quantity:</label>
        <input type="number" name="item_quantity" min="1">
        <label>Message (optional):</label>
        <textarea name="item_message" rows="3"></textarea>
    </div>

    <button type="submit">Donate</button>
</form>


<div class="stall-info">
    <h2>🐾 Pet Stall Location & Hours</h2>
    <p><strong>📍 Address:</strong> <?= htmlspecialchars($stall_address) ?></p>
    <p><strong>🕒 Schedule:</strong> <?= htmlspecialchars($stall_schedule) ?></p>
</div>

</body>
</html>
