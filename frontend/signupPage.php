<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <link rel="stylesheet" href="./css/style.css"> -->
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
            background: #6c5ce7;
            border: none;
            color: #fff;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 20px;
            font-size: 1rem;
        }

        .auth-btn:hover {
            background: #5848d1;
        }

        .login-btn {
            margin-top: 15px;
            background: #00b894;
        }

        .login-btn:hover {
            background: #019870;
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
        /* Login Button */
    .login-btn {
        display: inline-block;
        width: 100%;
        padding: 16px;
        background: #00b894; /* teal color */
        color: #fff;
        font-weight: bold;
        font-size: 1rem;
        border-radius: 10px;
        text-decoration: none;
        text-align: center;
        margin-top: 15px;
        cursor: pointer;
        transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 4px 10px rgba(0, 184, 148, 0.3);
    }

    .login-btn:hover {
        background: #019870; /* darker teal on hover */
        transform: translateY(-2px); /* slight lift */
        box-shadow: 0 6px 14px rgba(0, 184, 148, 0.4); /* stronger shadow */
    }

    </style>
</head>

<body>

<div class="auth-container">
    <div class="logo">WanderLux</div>
    
    <form method="POST" action="backend/signupHandler.php">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Create Password" required>
        <button class="auth-btn" type="submit">Sign Up</button>
    </form>

    <!-- Login link as button -->
    <a href="?page=loginPage" class="auth-btn login-btn">Login</a>

    <div class="auth-footer">
        By continuing, you agree to our <a href="#">Terms</a> & <a href="#">Privacy Policy</a>
    </div>
</div>

</body>
</html>
