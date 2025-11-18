<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user by email
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Verify password (passwords recommended)
        if ($password === $user['password']) {
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role']; // 'admin' or 'user'
            $_SESSION['user_name'] = $user['name'];

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: index.php?page=adminDashboard"); // Admin dashboard
                exit;
            } else {
                header("Location: index.php?page=userDashboard"); // User dashboard
                exit;
            }
        } else {
            echo "<p style='color:red;'>Incorrect password!</p>";
        }
    } else {
        echo "<p style='color:red;'>User not found!</p>";
    }
}
?>
