<?php
include 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$id = intval($_GET['id']);


$stmt = $conn->prepare("UPDATE food_donations SET confirmed_by_admin = 1, confirmed_date = NOW() WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    
    $stmt2 = $conn->prepare("SELECT u.email, u.name FROM food_donations f JOIN users u ON f.user_id = u.id WHERE f.id = ?");
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $stmt2->bind_result($email, $name);
    $stmt2->fetch();
    $stmt2->close();

   
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
         $mail->Username = 'sankalpananipuni132@gmail.com';          
    $mail->Password = 'lxgrxvyvmvcqpdxn';          
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('sankalpananipuni132@gmail.com', 'Pet Adoption Admin');
        $mail->addAddress($email, $name);
        $mail->Subject = 'Food Donation Confirmation';
        $mail->Body = "Dear $name,\n\nThank you for your food donation. We have received it successfully.\n\nBest regards,\nPet Adoption Team";

        $mail->send();
        header("Location: admin_food_donations.php?msg=confirmed");
        exit();
    } catch (Exception $e) {
        error_log("Email sending failed: " . $mail->ErrorInfo);
        header("Location: admin_food_donations.php?msg=email_failed");
        exit();
    }
} else {
    die("Failed to confirm donation.");
}
?>
