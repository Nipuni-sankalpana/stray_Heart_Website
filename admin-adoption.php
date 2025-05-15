<?php
include 'db.php';
$result = $conn->query("SELECT a.*, u.name AS user_name, u.email, p.name AS pet_name FROM adoptions a JOIN users u ON a.user_id = u.id JOIN pets p ON a.pet_id = p.id");
while($row = $result->fetch_assoc()) {
echo "<p>{$row['user_name']} requested {$row['pet_name']} - Status: {$row['status']} <a href='process_adoption.php?id={$row['id']}&action=accept'>Accept</a> | <a href='process_adoption.php?id={$row['id']}&action=reject'>Reject</a></p>";
}
?>