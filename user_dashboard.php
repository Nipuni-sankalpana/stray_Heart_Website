<?php
include 'db.php';
session_start();



$user_id = $_SESSION['user_id'];

// Get user information
$user = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();
?>

<h2>User Dashboard</h2>
<p>Welcome, <?php echo $user['name']; ?>!</p>

<h3>Your Adoption Requests</h3>
<?php
$sql = "SELECT * FROM adoptions WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p>Pet: " . $row['pet_name'] . " - Status: " . $row['status'] . "</p>";
    }
} else {
    echo "<p>You have no adoption requests.</p>";
}
?>

<h3>Your Donations</h3>
<?php
$sql = "SELECT * FROM donations WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p>Donation Type: " . $row['donation_type'] . " - Amount: " . ($row['donation_type'] === 'money' ? $row['amount'] : 'N/A') . "</p>";
    }
} else {
    echo "<p>You have not made any donations.</p>";
}
