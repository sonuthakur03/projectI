<?php
session_start();
include './connection.php';

// create users table if not exists
$users = "CREATE TABLE IF NOT EXISTS users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') DEFAULT 'user'
)";
mysqli_query($conn, $users);

// If signup request
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]); // escape special chars

    $sql = "INSERT INTO users(name, email, password) VALUES('$name','$email','$password')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION["message"] = "Signup Successful! Please Login.";
        header("Location: ../frontend/loginPage.php");
        exit();
    } else {
        $_SESSION["error"] = "Email already exists or error occurred!";
        header("Location: ../frontend/signupPage.php");
        exit();
    }
}
?>
