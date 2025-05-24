<?php
include 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';


if (!isset($_GET['id'])) {
    die("Invalid request");
}

$id = intval($_GET['id']);

// Update DB
$stmt = $conn->prepare("UPDATE item_donations SET confirmed_by_admin = 1, confirmed_date = NOW() WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    $stmt2 = $conn->prepare("SELECT u.email, u.name FROM item_donations i JOIN users u ON i.user_id = u.id WHERE i.id = ?");
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $stmt2->bind_result($email, $name);
    $stmt2->fetch();
    $stmt2->close();

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.example.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'your@email.com';
    $mail->Password = 'yourpassword';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('your@email.com', 'Pet Adoption Admin');
    $mail->addAddress($email, $name);
    $mail->Subject = 'Item Donation Confirmation';
    $mail->Body = "Dear $name,\n\nThank you for your item donation. We have received it successfully.\n\nBest regards,\nPet Adoption Team";

    if ($mail->send()) {
        header("Location: admin_item_donations.php?msg=confirmed");
    } else {
        header("Location: admin_item_donations.php?msg=email_failed");
    }
} else {
    die("Failed to confirm.");
}
?>
