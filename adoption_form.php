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
</head>
<body>

<div class="form-container">
    <!-- Decorative paw prints -->
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

</body>
</html>