<?php

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../frontend/loginPage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - WanderLux</title>
    <link rel="stylesheet" href="../frontend/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            padding: 40px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 40px;
        }

        .card {
            background: #fff;
            width: 250px;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
            padding: 20px;
            text-align: center;
            transition: transform 0.2s ease;
            cursor: pointer;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            margin-bottom: 15px;
            color: #6c5ce7;
        }

        .card a {
            text-decoration: none;
            color: #fff;
            background: #00b894;
            padding: 10px 15px;
            border-radius: 10px;
            display: inline-block;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .card a:hover {
            background: #019870;
        }
    </style>
</head>
<body>

    <?php include "header.php" ?>

<div class="dashboard-container">
    <h1>Admin Dashboard</h1>

    <div class="cards">
        <div class="card">
            <h3>Manage Destinations</h3>
            <a href="index.php?page=manageDestinations">Go</a>
        </div>
        <div class="card">
            <h3>Manage Hotels</h3>
            <a href="hotelsForm.php">Go</a>
        </div>
        <div class="card">
            <h3>Manage Transport</h3>
            <a href="transportForm.php">Go</a>
        </div>
        <div class="card">
            <h3>Manage Users</h3>
            <a href="users.php">Go</a>
        </div>
    </div>
</div>

    <?php include "footer.php" ?>

</body>
</html>
