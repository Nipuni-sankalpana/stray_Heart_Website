<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['donation_type'];

    if ($type === 'money') {
        $amount = floatval($_POST['amount']);
        $payment_method = $_POST['payment_method'];

        $stmt = $conn->prepare("INSERT INTO money_donations (user_id, amount, payment_method) VALUES (?, ?, ?)");
        $stmt->bind_param("ids", $user_id, $amount, $payment_method);
        if ($stmt->execute()) {
            $message = "Money donation successful. Thank you!";
        } else {
            $message = "Error processing donation.";
        }

    } elseif ($type === 'food') {
        $food_type = $_POST['food_type'];
        $quantity = floatval($_POST['food_quantity']);
        $msg = $_POST['food_message'];

        $stmt = $conn->prepare("INSERT INTO food_donations (user_id, food_type, quantity, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isds", $user_id, $food_type, $quantity, $msg);
        if ($stmt->execute()) {
            $message = "Food donation request sent. Waiting for admin confirmation.";
        } else {
            $message = "Error processing donation.";
        }

    } elseif ($type === 'item') {
        $item_name = $_POST['item_name'];
        $quantity = intval($_POST['item_quantity']);
        $msg = $_POST['item_message'];

        $stmt = $conn->prepare("INSERT INTO item_donations (user_id, item_name, quantity, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isis", $user_id, $item_name, $quantity, $msg);
        if ($stmt->execute()) {
            $message = "Item donation request sent. Waiting for admin confirmation.";
        } else {
            $message = "Error processing donation.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Make a Donation</title>
    <style>
        body { font-family: Arial; max-width: 700px; margin: auto; padding: 20px; }
        form { margin-bottom: 30px; }
        label { display: block; margin-top: 10px; }
        input, select, textarea { width: 100%; padding: 8px; }
        button { margin-top: 15px; padding: 10px 15px; background: #7f00ff; color: white; border: none; cursor: pointer; }
        .message { margin: 15px 0; color: green; }
    </style>
    <script>
        function showFields() {
            var type = document.getElementById('donation_type').value;
            document.getElementById('money_fields').style.display = (type === 'money') ? 'block' : 'none';
            document.getElementById('food_fields').style.display = (type === 'food') ? 'block' : 'none';
            document.getElementById('item_fields').style.display = (type === 'item') ? 'block' : 'none';
        }
    </script>
</head>
<body onload="showFields()">

<h1>Make a Donation</h1>

<?php if ($message) echo "<div class='message'>$message</div>"; ?>

<form method="POST" action="">
    <label for="donation_type">Donation Type:</label>
    <select id="donation_type" name="donation_type" onchange="showFields()" required>
        <option value="money">Money</option>
        <option value="food">Food</option>
        <option value="item">Item</option>
    </select>

    <!-- Money -->
    <div id="money_fields" style="display:none;">
        <label>Amount (LKR):</label>
        <input type="number" name="amount" step="0.01" min="1">
        <label>Payment Method:</label>
        <select name="payment_method">
            <option value="Online">Online</option>
            <option value="Physical">Physical</option>
        </select>
    </div>

    <!-- Food -->
    <div id="food_fields" style="display:none;">
        <label>Food Type:</label>
        <input type="text" name="food_type" maxlength="255">
        <label>Quantity (kg):</label>
        <input type="number" name="food_quantity" step="0.01" min="1">
        <label>Message (optional):</label>
        <textarea name="food_message" rows="3"></textarea>
    </div>

    <!-- Item -->
    <div id="item_fields" style="display:none;">
        <label>Item Name:</label>
        <input type="text" name="item_name" maxlength="255">
        <label>Quantity:</label>
        <input type="number" name="item_quantity" min="1">
        <label>Message (optional):</label>
        <textarea name="item_message" rows="3"></textarea>
    </div>

    <button type="submit">Donate</button>
</form>

</body>
</html>
