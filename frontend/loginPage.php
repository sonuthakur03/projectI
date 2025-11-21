<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .auth-container {
            width: 400px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            padding: 50px 40px;
            text-align: center;
        }

        .auth-container h2 {
            margin-bottom: 25px;
            color: #333;
        }

        .error-box {
            background: #ffdddd;
            color: #d9534f;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #d9534f;
            border-radius: 8px;
            font-weight: bold;
        }

        .auth-container input {
            width: 100%;
            padding: 16px;
            margin: 12px 0;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        .auth-btn {
            width: 100%;
            padding: 16px;
            background: #00b894;
            border: none;
            color: #fff;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 20px;
            font-size: 1rem;
        }

        .auth-btn:hover {
            background: #019870;
        }

        .signup-btn {
            margin-top: 15px;
            background: #6c5ce7;
        }

        .signup-btn:hover {
            background: #5848d1;
        }

        .auth-footer {
            margin-top: 20px;
            font-size: 0.9rem;
        }

        .auth-footer a {
            color: #6c5ce7;
            text-decoration: none;
            font-weight: bold;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #6c5ce7;
        }
    </style>
</head>

<body>

<div class="auth-container">

        <div class="logo">WanderLux</div>

        <!-- Error Message -->
        <?php 
        if (isset($_SESSION['error'])) { 
            echo "<div class='error-box'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']); 
        } 
        ?>

        <form method="POST" action="index.php?page=loginHandler">
            <input type="email" name="email" placeholder="Enter email" required>
            <input type="password" name="password" placeholder="Enter password" required>
            <button class="auth-btn" type="submit">Login</button>
        </form>

        <a href="index.php?page=signupPage">
            <button class="auth-btn signup-btn" type="button">Sign Up</button>
        </a>

        <div class="auth-footer">
            By continuing, you agree to our <a href="#">Terms</a> & <a href="#">Privacy Policy</a>
        </div>
</div>

</body>
</html>
