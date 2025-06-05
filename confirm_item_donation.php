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


$stmt = $conn->prepare("UPDATE item_donations SET confirmed_by_admin = 1, confirmed_date = NOW() WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $stmt2 = $conn->prepare("SELECT u.email, u.name FROM item_donations i JOIN users u ON i.user_id = u.id WHERE i.id = ?");
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $stmt2->bind_result($email, $name);
    $stmt2->fetch();
    $stmt2->close();

    $mail = new PHPMailer(true);

    try {
        
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->Username = 'sankalpananipuni132@gmail.com';        
    $mail->Password = 'lxgrxvyvmvcqpdxn'; 

       
        $mail->setFrom('sankalpananipuni132@gmail.com', 'Pet Adoption Admin');
        $mail->addAddress($email, $name);

        
        $mail->isHTML(false);
        $mail->Subject = 'Item Donation Confirmation';
        $mail->Body    = "Dear $name,\n\nThank you for your item donation. We have received it successfully.\n\nBest regards,\nStray Heart";

        $mail->send();
        header("Location: admin_item_donations.php?msg=confirmed");
        exit();
    } catch (Exception $e) {
        
        header("Location: admin_item_donations.php?msg=email_failed");
        exit();
    }
} else {
    die("Failed to confirm.");
}
?>
