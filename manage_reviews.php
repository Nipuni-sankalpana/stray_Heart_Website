<?php
include 'db.php';
$result = mysqli_query($conn, "SELECT * FROM reviews ORDER BY created_at DESC");

echo "<h2>Manage Reviews</h2><table class='table'><tr><th>User</th><th>Review</th><th>Action</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>{$row['username']}</td>
        <td>{$row['message']}</td>
        <td><a href='delete_review.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a></td>
    </tr>";
}
echo "</table>";
?>
