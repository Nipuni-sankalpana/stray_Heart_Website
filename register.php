<?php
include 'db.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); 


$admin_emails = ['admin@example.com'];


$role = in_array($email, $admin_emails) ? 'admin' : 'user';

$sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $email, $password, $role);

if ($stmt->execute()) {
    echo "Signup successful. <a href='login.php'>Login</a>";
} else {
    echo "Signup failed: " . $stmt->error;
}
?>
