<?php
session_start();
include 'db.php'; 



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $schedule = mysqli_real_escape_string($conn, $_POST['schedule']);

    
    $check = mysqli_query($conn, "SELECT * FROM pet_stalls");
    if (mysqli_num_rows($check) > 0) {
        
        mysqli_query($conn, "UPDATE pet_stalls SET address='$address', schedule='$schedule'");
    } else {
       
        mysqli_query($conn, "INSERT INTO pet_stalls (address, schedule) VALUES ('$address', '$schedule')");
    }
    $message = "Stall info saved successfully.";
}


$result = mysqli_query($conn, "SELECT * FROM pet_stalls LIMIT 1");
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Pet Stall Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Manage Pet Stall Information</h2>
    
    <?php if (isset($message)): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Pet Stall Address</label>
            <textarea name="address" class="form-control" rows="3" required><?= $row['address'] ?? '' ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Pet Stall Schedule</label>
            <input type="text" name="schedule" class="form-control" value="<?= $row['schedule'] ?? '' ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Info</button>
    </form>
</div>
</body>
</html>
