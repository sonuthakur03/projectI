<?php
include __DIR__ . '/../backend/connection.php';

// Only logged-in users
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user') {
    header("Location: ../index.php?page=loginPage");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch hotel bookings
$hotelBookings = mysqli_query($conn, "
    SELECT b.*, h.name AS hotel_name 
    FROM bookings b
    JOIN hotels h ON b.hotel_id = h.id
    WHERE b.user_id = '$user_id'
    ORDER BY b.booking_date DESC
");

// Fetch transport bookings
$transportBookings = mysqli_query($conn, "
    SELECT t.*, tr.name AS transport_name 
    FROM transport_bookings t
    JOIN transport tr ON t.transport_id = tr.id
    WHERE t.user_id = '$user_id'
    ORDER BY t.booking_date DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Dashboard - WanderLux</title>
<link rel="stylesheet" href="../frontend/css/style.css">
<style>
body { font-family: Arial,sans-serif; margin:0; padding:0; background:#f2f2f2; }
.page-wrapper { display:flex; margin-top:60px;height:calc(100vh - 60px); }

/* Sidebar */
.sidebar { width:250px; background:#00a38eff; color:white; padding:40px 20px; position:sticky; top:0; display:flex; flex-direction:column; }
.sidebar .profile h3 { margin:0; font-size:2rem; background:white; color:#584db1ff; width:70px; height:70px; line-height:70px; text-align:center; border-radius:50%; font-weight:bold; }
.sidebar .profile p { font-size:0.9rem; color:#e0e0ff; margin-top:10px; text-align:center; }
.sidebar nav a { display:block; padding:12px 15px; margin:10px 0; background:rgba(255,255,255,0.1); color:white; border-radius:8px; text-decoration:none; transition:0.2s; }
.sidebar nav a:hover, .sidebar nav a.active { background:rgba(255,255,255,0.2); }

/* Main content */
.main-content { flex:1; padding:40px; }
h1 { text-align:center; color:#333; margin-bottom:30px; }

/* Dashboard cards */
.cards { display:grid; grid-template-columns:repeat(auto-fit, minmax(250px,1fr)); gap:30px; justify-items:center; }
.card { display:flex; flex-direction:column; align-items:center; width:100%; min-height:150px; background:#ffffff; border-radius:15px; box-shadow:0 4px 10px rgba(0,0,0,0.1); padding:20px; text-align:center; transition:transform 0.2s ease; cursor:pointer; }
.card:hover { transform:translateY(-5px); box-shadow:0 8px 20px rgba(0,0,0,0.15); }
.card-icon { font-size:3rem; margin-bottom:15px; }
.card h3 { margin-bottom:10px; color:#6c5ce7; }
.card a { text-decoration:none; color:#fff; background:#00b894; padding:10px 20px; border-radius:10px; font-weight:bold; transition:background 0.3s ease; }
.card a:hover { background:#019870; }

/* Booking cards */
.booking-card { background:#fdfdfd; border-left:5px solid #6c5ce7; margin-bottom:15px; padding:15px 20px; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.1); width:100%; text-align:left; }
.booking-card h4 { margin:0 0 10px 0; color:#584db1; }
.booking-card p { margin:3px 0; color:#333; }
.booking-card a { margin-right:10px; padding:5px 10px; border-radius:5px; background:#6c5ce7; color:#fff; text-decoration:none; font-size:0.9rem; }
.booking-card a.delete { background:#ff7675; }
</style>
</head>
<body>

<div class="page-wrapper">

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="profile">
            <h3><?= strtoupper(substr($_SESSION['user_name'],0,1)) ?></h3>
            <p><?= $_SESSION['user_name'] ?></p>
        </div>
        <nav>
            <a href="index.php?page=destinations">Destinations</a>
            <a href="index.php?page=hotels">Hotels</a>
            <a href="index.php?page=transport">Transport</a>
            <a href="index.php?page=manageBooking&type=hotel">My Bookings</a>
        </nav>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <h1>Welcome, <?= $_SESSION['user_name']; ?>!</h1>

        <div class="cards">
            <div class="card" onclick="window.location='index.php?page=destinations'">
                <div class="card-icon">🗺️</div>
                <h3>View Destinations</h3>
                <a href="index.php?page=destinations">Explore →</a>
            </div>
            <div class="card" onclick="window.location='index.php?page=hotels'">
                <div class="card-icon">🏨</div>
                <h3>View Hotels</h3>
                <a href="index.php?page=hotels">Check →</a>
            </div>
            <div class="card" onclick="window.location='index.php?page=transport'">
                <div class="card-icon">🚗</div>
                <h3>View Transport</h3>
                <a href="index.php?page=transport">Browse →</a>
            </div>
        </div>

        <!-- Recent Hotel Bookings -->
        <h2 style="margin-top:40px;">Your Recent Hotel Bookings</h2>
        <?php if(mysqli_num_rows($hotelBookings) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($hotelBookings)): ?>
                <div class="booking-card">
                    <h4><?= htmlspecialchars($row['hotel_name']) ?></h4>
                    <p>Check-in: <?= $row['check_in'] ?> | Check-out: <?= $row['check_out'] ?></p>
                    <p>Guests: <?= $row['guests'] ?> | Total Price: NPR <?= number_format($row['total_price'],2) ?></p>
                    <p>Status: <?= $row['status'] ?></p>
                    <!-- Hotel Booking -->
                    <a href="index.php?page=manageUserBooking&type=hotel">View</a>
                </div>
                <?php endwhile; ?>
                <?php else: ?>
                    <p style="text-align:center;">No hotel bookings found.</p>
                    <?php endif; ?>
                    
                    <!-- Recent Transport Bookings -->
                    <h2 style="margin-top:40px;">Your Recent Transport Bookings</h2>
                    <?php if(mysqli_num_rows($transportBookings) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($transportBookings)): ?>
                            <div class="booking-card" style="border-left-color:#00a38eff;">
                                <h4><?= htmlspecialchars($row['transport_name']) ?></h4>
                                <p>Travel Date: <?= $row['travel_date'] ?></p>
                                <p>Guests: <?= $row['guests'] ?> | Total Price: NPR <?= number_format($row['total_price'],2) ?></p>
                                <p>Status: <?= $row['status'] ?></p>
                                <a href="index.php?page=manageUserBooking&type=transport">View</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center;">No transport bookings found.</p>
        <?php endif; ?>

    </div>
</div>
</body>
</html>
