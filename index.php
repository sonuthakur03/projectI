<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WanderLux - Discover Your Next Dream Destination</title>
    <link rel="stylesheet" href="./frontend/css/style.css">
</head>

<body>

<?php
include __DIR__ . '/frontend/header.php';
session_start();
// Routing logic
$pages = ['home', 'hotels', 'destinations', 'transport', 'signupPage', 'loginPage','dashboard'];
$page = $_GET['page'] ?? 'home';

$basePath = __DIR__ . "/frontend/";

if (in_array($page, $pages)) {
    include $basePath . $page . '.php';
} else {
    echo "<h1>404 Page Not Found</h1>";
}

// include __DIR__ . '/frontend/footer.php';
?>

<script src="./frontend/js/index.js"></script>

</body>
</html>
