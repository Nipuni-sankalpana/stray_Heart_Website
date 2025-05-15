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
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #e1f7f5, #f7e1f5);
            margin: 0;
            padding: 0;
        }

        .form-container {
            background: #fff;
            max-width: 600px;
            margin: 50px auto;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #7f00ff;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #444;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: #e100ff;
            outline: none;
        }

        button {
            background: linear-gradient(45deg, #7f00ff, #e100ff);
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
        }

        button:hover {
            background: linear-gradient(45deg, #6a00cc, #cc00cc);
        }

        .message-box {
            margin-top: 30px;
            padding: 15px;
            background: #fef6e4;
            border-left: 5px solid #ffb703;
            font-size: 14px;
            color: #444;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="form-container">
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

        <div class="form-group">
            <label for="note">Additional Note:</label>
            <textarea name="note" id="note" placeholder="Anything else we should know?"></textarea>
        </div>

        <button type="submit">Send Adoption Request</button>
    </form>

    <div class="message-box">
        <strong>Reminder:</strong> Adopting a pet is a lifetime commitment. Please ensure you can provide a safe, loving, and healthy environment. They deserve your time, love, and care.
    </div>
</div>

</body>
</html>
