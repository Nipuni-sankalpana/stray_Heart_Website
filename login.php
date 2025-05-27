<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];

            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: index.php");
            }
        } else {
            $error = "Invalid credentials.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Your Brand</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --lavender: #E6E6FA;
            --soft-lavender: #F5F5FF;
            --dark-lavender: #B0A8D0;
            --black: #1A1A1A;
            --white: #FFFFFF;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background-image: url(assets/images/hospital\ bg.png);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--black);
        }
        
        .login-container {
            background: transparent;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            width: 400px;
            padding: 48px;
            text-align: center;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .logo {
            width: 60px;
            margin-bottom: 24px;
            filter: brightness(0) saturate(100%) invert(15%) sepia(4%) saturate(1194%) hue-rotate(315deg) brightness(93%) contrast(85%);
        }
        
        h2 {
            margin-bottom: 32px;
            color: var(--black);
            font-weight: 600;
            font-size: 24px;
        }
        
        .input-group {
            margin-bottom: 24px;
            text-align: left;
        }
        
        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--black);
            font-size: 14px;
        }
        
        .input-group input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #E0E0E0;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.2s;
            background-color: var(--soft-lavender);
        }
        
        .input-group input:focus {
            border-color: var(--dark-lavender);
            outline: none;
            box-shadow: 0 0 0 3px rgba(182, 172, 208, 0.15);
            background-color: var(--white);
        }
        
        .btn {
            background-color: var(--black);
            color: var(--white);
            border: none;
            padding: 14px 0;
            width: 100%;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 8px;
        }
        
        .btn:hover {
            background-color: #2C2C2C;
            transform: translateY(-1px);
        }
        
        .forgot-password {
            display: block;
            margin-top: 16px;
            color: var(--dark-lavender);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }
        
        .forgot-password:hover {
            color: var(--black);
        }
        
        .error-message {
            color: #D32F2F;
            background-color: #FFEBEE;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 24px;
            font-size: 14px;
            display: <?php echo isset($error) ? 'block' : 'none'; ?>;
            border: 1px solid #EF9A9A;
        }
        
        .footer-text {
            margin-top: 32px;
            font-size: 14px;
            color: #666;
        }
        
        .footer-text a {
            color: var(--dark-lavender);
            text-decoration: none;
            font-weight: 500;
        }
        
        .footer-text a:hover {
            color: var(--black);
            text-decoration: underline;
        }
        
        /* Modern subtle animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .login-container {
            animation: fadeIn 0.4s ease-out;
        }
    </style>
</head>
<body>

<div class="login-container">
    <img src="assets/images/dog_2437791.png" alt="Logo" class="logo">
    <h2>Login Here</h2>

    <?php if(isset($error)): ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="input-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required placeholder="your@email.com">
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required placeholder="••••••••">
        </div>

        <button type="submit" class="btn">Login</button>
    </form>

    <p class="signup-message">Don't have an account? <a href="register.php">Create one</a></p>
</div>


</body>
</html>