<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../frontend/loginPage.php");
    exit();
}

include __DIR__ . '/../backend/connection.php';

// Fetch stats
$totalDestinations = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM destinations"))['total'];
$totalHotels = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM hotels"))['total'];
$totalTransport = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM transport"))['total'];
$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
$totalHotelBookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM bookings"))['total'];
$totalTransportBookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM transport_bookings"))['total'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - WanderLux</title>
        <style>
            /* same styling as before */
            body { 
                font-family: Arial, sans-serif; 
                margin:0; padding:0; 
                background:#f2f2f2; 
            }
            .page-wrapper { 
                display:flex; 
                margin-top:60px; 
            }
            .sidebar { 
                width:250px; 
                background:#00a38eff; 
                color:white; 
                display:flex; 
                flex-direction:column; 
                padding:40px 20px; 
                position:sticky; 
                top:0; 
            }
            .sidebar .profile { 
                display:flex; 
                flex-direction:column; 
                align-items:center; 
                margin-bottom:50px; 
            }
            .sidebar .profile h3 { 
                margin:0; 
                font-size:2rem; 
                background:white; 
                color:#584db1ff; 
                width:70px; 
                height:70px; 
                line-height:70px; 
                text-align:center; 
                border-radius:50%; 
                font-weight:bold; 
            }
            .sidebar .profile p { 
                font-size:0.9rem; 
                olor:#e0e0ff; 
                margin-top:10px; 
            }
            .sidebar nav a { 
                display:block; 
                padding:12px 15px; 
                margin:10px 0; 
                background:rgba(255,255,255,0.1); 
                color:white; 
                border-radius:8px; 
                text-decoration:none; 
                transition:0.2s; 
            }
            .sidebar nav a:hover { 
                background:rgba(255,255,255,0.2); 
            }
            .main-content { 
                flex:1; 
                padding:40px; 
                margin-bottom:80px; 
            }
            h1 { 
                text-align:center; 
                color:#333; 
                margin-bottom:30px; 
            }
            .stats-cards { 
                display:grid; 
                grid-template-columns:1fr 1fr; 
                gap:30px; 
            }
            .card { 
                display:flex; 
                align-items:center; 
                width:100%; 
                min-height:120px; 
                background:#fff; 
                border-radius:15px; 
                box-shadow:0 4px 10px rgba(0,0,0,0.1); 
                padding:15px 20px; 
                transition:all 0.2s ease; 
                cursor:pointer; 
            }
            .card:hover { 
                transform:translateY(-3px); 
                box-shadow:0 8px 20px rgba(0,0,0,0.15); 
            }
            .card-icon { 
                font-size:2.5rem; 
                margin-right:20px; 
            }
            .card-info h3 { 
                margin:0 0 5px 0; 
                color:#6c5ce7; 
            }
            .card-info p { 
                font-size:1.2rem; 
                font-weight:bold; 
                margin:0; 
                color:#333; 
            }
            .card-info small { 
                display:block; 
                margin:5px 0; 
                color:#555; 
            }
            .card-info a { 
                text-decoration:none; 
                color:#6c5ce7; 
                font-weight:bold; 
                margin-top:5px; 
                display:inline-block; 
            }
            .card-info a:hover { 
                text-decoration:underline; 
            }
            @media (max-width:768px) {
                .page-wrapper { 
                    flex-direction:column; 
                }
                .sidebar { 
                    width:100%;
                    flex-direction:row; 
                    justify-content:space-around; 
                    padding:20px; 
                }
                .sidebar .profile h3 {
                    width:50px; 
                    height:50px; 
                    line-height:50px; 
                    font-size:0.9rem; 
                }
                .main-content { 
                    padding:20px; 
                }
                .stats-cards {
                    flex-direction:column; 
                    align-items:center; 
                }
                .card { 
                    width:90%; 
                }
            }
        </style>
    </head>
<body>

<div class="page-wrapper">
    <div class="sidebar">
        <div class="profile">
            <h3><?= strtoupper(substr($_SESSION['user_name'] ?? 'A',0,1)) ?></h3>
            <p><?= $_SESSION['user_role'] ?? 'Admin' ?></p>
        </div>
        <nav>
            <a href="index.php?page=manageDestinations">Destinations</a>
            <a href="index.php?page=manageHotels">Hotels</a>
            <a href="index.php?page=manageTransport">Transport</a>
            <a href="index.php?page=manageUsers">Users</a>
            <a href="index.php?page=manageBooking&type=hotel">Bookings</a>
        </nav>
    </div>

    <div class="main-content">
        <h1>Admin Dashboard</h1>
        <div class="stats-cards">

            <div class="card" onclick="window.location='index.php?page=manageDestinations'">
                <div class="card-icon">🗺️</div>
                <div class="card-info">
                    <h3>Destinations</h3>
                    <p><?= $totalDestinations ?> Total</p>
                    <small>Click to view/manage destinations</small>
                    <a href="index.php?page=manageDestinations">View →</a>
                </div>
            </div>

            <div class="card" onclick="window.location='index.php?page=manageHotels'">
                <div class="card-icon">🏨</div>
                <div class="card-info">
                    <h3>Hotels</h3>
                    <p><?= $totalHotels ?> Total</p>
                    <small>Click to view/manage hotels</small>
                    <a href="index.php?page=manageHotels">View →</a>
                </div>
            </div>

            <div class="card" onclick="window.location='index.php?page=manageTransport'">
                <div class="card-icon">🚗</div>
                <div class="card-info">
                    <h3>Transport</h3>
                    <p><?= $totalTransport ?> Total</p>
                    <small>Click to view/manage transport</small>
                    <a href="index.php?page=manageTransport">View →</a>
                </div>
            </div>

            <div class="card" onclick="window.location='index.php?page=manageUsers'">
                <div class="card-icon">👥</div>
                <div class="card-info">
                    <h3>Users</h3>
                    <p><?= $totalUsers ?> Total</p>
                    <small>Click to view/manage users</small>
                    <a href="index.php?page=manageUsers">View →</a>
                </div>
            </div>

            <div class="card" onclick="window.location='index.php?page=manageBooking&type=hotel'">
                <div class="card-icon">🏨</div>
                <div class="card-info">
                    <h3>Hotel Bookings</h3>
                    <p><?= $totalHotelBookings ?> Total</p>
                    <small>Click to view/manage hotel bookings</small>
                    <a href="index.php?page=manageBooking&type=hotel">View →</a>
                </div>
            </div>

            <div class="card" onclick="window.location='index.php?page=manageBooking&type=transport'">
                <div class="card-icon">🚗</div>
                <div class="card-info">
                    <h3>Transport Bookings</h3>
                    <p><?= $totalTransportBookings ?> Total</p>
                    <small>Click to view/manage transport bookings</small>
                    <a href="index.php?page=manageBooking&type=transport">View →</a>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
