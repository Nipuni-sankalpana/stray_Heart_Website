<?php


include 'db.php'; 


$success = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_stall'])) {
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $open_hours = mysqli_real_escape_string($conn, $_POST['open_hours']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);

    $sql = "INSERT INTO pet_stall (address, open_hours, contact) VALUES ('$address', '$open_hours', '$contact')";

    if (mysqli_query($conn, $sql)) {
        $success = "✅ Pet stall added successfully!";
    } else {
        $success = "❌ Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Pet Stall</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            padding: 20px;
        }
        .form-container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type=text], textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        input[type=submit] {
            background-color:#5A3D7A;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
        }
        .msg {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
            color: green;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Add Pet Stall Information</h2>

    <?php if ($success != '') echo "<div class='msg'>$success</div>"; ?>

    <form method="POST" action="">
        <label for="address">Address:</label>
        <textarea name="address" required></textarea>

        <label for="open_hours">Open Hours:</label>
        <input type="text" name="open_hours" placeholder="e.g., 9 AM - 6 PM" required>

        <label for="contact">Contact:</label>
        <input type="text" name="contact" placeholder="e.g., 0771234567" required>

        <input type="submit" name="add_stall" value="Add Stall">
    </form>
</div>

</body>
</html>
