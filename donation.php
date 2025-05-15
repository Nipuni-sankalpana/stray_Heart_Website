<?php
include 'db.php';
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle donation submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $donation_type = $_POST['donation_type'];
    $amount = $_POST['amount']; // Only for money donations
    $message = $_POST['message'];

    // Insert donation record
    $sql = "INSERT INTO donations (user_id, donation_type, amount, message) 
            VALUES ('$user_id', '$donation_type', '$amount', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Donation successful! Thank you for your generosity.'); window.location='donation.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<h2>Make a Donation</h2>
<form method="post">
    <label for="donation_type">Donation Type:</label><br>
    <input type="radio" id="money" name="donation_type" value="money" required> Money<br>
    <input type="radio" id="food" name="donation_type" value="food" required> Food<br>
    <input type="radio" id="items" name="donation_type" value="items" required> Items<br><br>

    <div id="money-amount" style="display:none;">
        <label for="amount">Amount (in USD):</label>
        <input type="number" name="amount" min="1" step="any" placeholder="Enter amount" /><br>
    </div>

    <label for="message">Additional Message (Optional):</label><br>
    <textarea name="message" rows="4" cols="50"></textarea><br><br>

    <button type="submit">Donate</button>
</form>

<script>
    // Show money amount field if "Money" is selected
    const radioButtons = document.querySelectorAll('input[name="donation_type"]');
    radioButtons.forEach(button => {
        button.addEventListener('change', function() {
            if (this.value === "money") {
                document.getElementById("money-amount").style.display = "block";
            } else {
                document.getElementById("money-amount").style.display = "none";
            }
        });
    });
</script>
