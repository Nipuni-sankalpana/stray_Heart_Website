<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost:3307", "root", "12345", "stray_heart");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];


$stmt = $conn->prepare("SELECT a.*, p.name AS pet_name 
                        FROM adoptions a 
                        JOIN pets p ON a.pet_id = p.id 
                        WHERE a.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="assets/css/user-dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding-top: 56px;
            color: black;
            line-height: 1.6;
            background: #f9f9f9;
        }

        .navbar {
            background-color: #e3d7ed!important;
        }

        .navbar-brand {
            font-weight: 700;
        }

        .nav-link {
            color: black !important;
            font-weight: 500;
        }

        .nav-link:hover {
            color: black !important;
        }

        .btn-adopt {
            background-color: #E3D7ED;
            color: black !important;
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
        }

        .btn-adopt:hover {
            background-color: #d0c4dd;
            transform: translateY(-2px);
        }

        h3 {
            margin-top: 30px;
            text-align: center;
            color: #333;
        }

        table {
            margin: 20px auto;
            width: 80%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #E3D7ED;
            color: #333;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#"><span style="color: black;">Stray</span> <span style="color:#5A3D7A;">Heart</span></a>
        <button class="navbar-toggler bg-black" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="pet_list.php">Pet List</a></li>
                <li class="nav-item"><a class="nav-link" href="hospital.php">Hospitals</a></li>
                <li class="nav-item"><a class="nav-link" href="donate.php">Donation</a></li>
                
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Admin</a></li>
                <?php endif; ?>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle fa-lg"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="profile.php">View Profile</a></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link btn-adopt" href="login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<h3>🐾 My Adoption Requests</h3>

<table>
    <tr>
        <th>Pet</th>
        <th>Status</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['pet_name']) ?></td>
                <td>
                    <?php if ($row['status'] === 'Pending'): ?>
                        ⏳ Pending
                    <?php elseif ($row['status'] === 'Accepted'): ?>
                        ✅ Accepted
                    <?php else: ?>
                        ❌ Rejected
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="2">No adoption requests yet.</td></tr>
    <?php endif; ?>
</table>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
