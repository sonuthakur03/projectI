<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'connection.php';

// Create 'users' table if it doesn't exist
$createTableSQL = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
";

if (!mysqli_query($conn, $createTableSQL)) {
    die("Error creating table: " . mysqli_error($conn));
}

// Optional: Insert a default admin user if table is empty
$checkAdmin = mysqli_query($conn, "SELECT * FROM users WHERE role='admin'");
if (mysqli_num_rows($checkAdmin) == 0) {
    $defaultPassword = 'admin123'; // Change to a secure password
    mysqli_query($conn, "INSERT INTO users (name, email, password, role) VALUES ('Admin', 'admin@example.com', '$defaultPassword', 'admin')");
}

// Login logic
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
                header("Location: index.php?page=adminDashboard");
                exit;
            } else {
                header("Location: index.php?page=userDashboard");
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
