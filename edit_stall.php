<?php
session_start();
include 'db.php';


$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM pet_stall WHERE id = $id");
if ($result->num_rows === 0) {
    die("Stall not found");
}
$stall = $result->fetch_assoc();

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = trim($_POST['address']);
    $open_hours = trim($_POST['open_hours']);
    $contact = trim($_POST['contact']);

    if ($address && $open_hours && $contact) {
        $stmt = $conn->prepare("UPDATE pet_stall SET address = ?, open_hours = ?, contact = ? WHERE id = ?");
        $stmt->bind_param("sssi", $address, $open_hours, $contact, $id);

        if ($stmt->execute()) {
            $success = "Stall updated successfully!";
        } else {
            $error = "Error updating stall: " . $stmt->error;
        }
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pet Stall</title>
    <style>
        body { font-family: Arial; padding: 30px; }
        form { max-width: 500px; margin: auto; background: #f9f9f9; padding: 20px; border-radius: 10px; }
        input, textarea { width: 100%; padding: 10px; margin-top: 10px; }
        button { background: #7f00ff; color: white; border: none; padding: 10px 20px; margin-top: 15px; border-radius: 5px; cursor: pointer; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>

<h2>Edit Pet Stall</h2>

<?php if ($success): ?>
    <p class="success"><?= $success ?></p>
<?php elseif ($error): ?>
    <p class="error"><?= $error ?></p>
<?php endif; ?>

<form method="POST">
    <label>Address:</label>
    <textarea name="address" required><?= htmlspecialchars($stall['address']) ?></textarea>

    <label>Open Hours:</label>
    <input type="text" name="open_hours" value="<?= $stall['open_hours'] ?>" required>

    <label>Contact:</label>
    <input type="text" name="contact" value="<?= $stall['contact'] ?>" required>

    <button type="submit">Update Stall</button>
</form>

</body>
</html>
