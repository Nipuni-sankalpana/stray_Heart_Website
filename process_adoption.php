<?php
include 'db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

// Get adoption ID and action
$id = $_GET['id'];
$action = $_GET['action'];
$status = ($action === 'accept') ? 'Accepted' : 'Rejected';

// Update adoption status in DB
$update = $conn->prepare("UPDATE adoptions SET status = ? WHERE id = ?");
$update->bind_param("si", $status, $id);
$update->execute();

// Fetch user email and pet name
$sql = "SELECT a.*, u.email, u.name AS user_name, p.name AS pet_name 
        FROM adoptions a 
        JOIN users u ON a.user_id = u.id 
        JOIN pets p ON a.pet_id = p.id 
        WHERE a.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

// Send email notification
$mail = new PHPMailer(true);

try {
    // SMTP settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'sankalpananipuni132@gmail.com';        // Your Gmail address
    $mail->Password   = 'lxgrxvyvmvcqpdxn';            // Gmail App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    // Sender and recipient
    $mail->setFrom('sankalpananipuni132@gmail.com', 'Pet Adoption Admin');
    $mail->addAddress($data['email'], $data['user_name']);
    $mail->addReplyTo('sankalpananipuni132@gmail.com', 'Pet Adoption Support');

    // Headers
    $mail->addCustomHeader('X-Mailer', 'PHPMailer');
    $mail->addCustomHeader('Precedence', 'bulk');

    // Content
    $mail->isHTML(true);
    $mail->Subject = "Adoption Request {$status}";
    $mail->Body = "
        <p>Hi {$data['user_name']},</p>
        <p>Your request to adopt <strong>{$data['pet_name']}</strong> has been <strong>{$status}</strong>.</p>
        <p>Thank you for supporting our mission!</p>
        <br><p>Regards,<br>Pet Adoption Admin</p>
    ";
    $mail->AltBody = "Hi {$data['user_name']}, Your adoption request for {$data['pet_name']} has been {$status}.";

    $mail->send();
    echo "Email sent successfully.";

} catch (Exception $e) {
    echo "Email failed: {$mail->ErrorInfo}";
}
?>
