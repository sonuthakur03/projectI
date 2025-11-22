<?php
session_start(); // Start session at the top
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WanderLux - Discover Your Next Dream Destination</title>
    <!-- Main CSS -->
    <link rel="stylesheet" href="/projectI/frontend/css/style.css">
</head>

<body>

<?php


// Pages allowed in frontend
$frontendPages = ['home','hotels','destinations','transport','signupPage','loginPage','adminDashboard','userDashboard','manageDestinations','manageHotels','manageTransport','manageUsers','manageBooking','manageUserBooking', 'aboutUs'];

// Pages allowed in backend
$backendPages = ['logout','destinationsForm','hotelsForm','transportForm','loginHandler','signupHandler','bookHotel','bookTransport'];

$page = $_GET['page'] ?? 'home';

// Include header always
include __DIR__ . '/frontend/header.php';

// Routing
if (in_array($page, $frontendPages)) {
    include __DIR__ . "/frontend/$page.php";
} elseif (in_array($page, $backendPages)) {
    include __DIR__ . "/backend/$page.php";
} else {
    echo "<h1 style='text-align:center; margin-top:50px;'>404 Page Not Found</h1>";
}
?>

<!-- Main JS -->
<script src="./frontend/js/index.js"></script>

</body>
</html>
