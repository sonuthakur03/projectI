<?php
session_start();
include __DIR__ . '/../backend/connection.php';

// Only allow logged-in users
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user') {
    header("Location: ../index.php?page=loginPage");
    exit();
}

$user_id = $_SESSION['user_id'];
$type = $_GET['type'] ?? 'hotel';

// Handle delete
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $table = $type === 'hotel' ? 'bookings' : 'transport_bookings';
    mysqli_query($conn, "DELETE FROM $table WHERE id=$delete_id AND user_id=$user_id");
    header("Location: index.php?page=manageUserBooking&type=$type");
    exit();
}

// Handle edit submission
if (isset($_POST['update_booking'])) {
    $edit_id = intval($_POST['edit_id']);
    $table = $type === 'hotel' ? 'bookings' : 'transport_bookings';

    if ($type === 'hotel') {
        $check_in = $_POST['check_in'];
        $check_out = $_POST['check_out'];
        $guests = intval($_POST['guests']);
        mysqli_query($conn, "UPDATE $table SET check_in='$check_in', check_out='$check_out', guests=$guests WHERE id=$edit_id AND user_id=$user_id");
    } else {
        $travel_date = $_POST['travel_date'];
        $guests = intval($_POST['guests']);
        mysqli_query($conn, "UPDATE $table SET travel_date='$travel_date', guests=$guests WHERE id=$edit_id AND user_id=$user_id");
    }

    header("Location: index.php?page=manageUserBooking&type=$type");
    exit();
}

// Fetch bookings
if ($type === 'hotel') {
    $bookings = mysqli_query($conn, "
        SELECT b.*, h.name AS hotel_name 
        FROM bookings b
        JOIN hotels h ON b.hotel_id = h.id
        WHERE b.user_id = $user_id
        ORDER BY b.booking_date DESC
    ");
} else {
    $bookings = mysqli_query($conn, "
        SELECT t.*, tr.name AS transport_name 
        FROM transport_bookings t
        JOIN transport tr ON t.transport_id = tr.id
        WHERE t.user_id = $user_id
        ORDER BY t.booking_date DESC
    ");
}

// Fetch booking to edit if requested
$edit_booking = null;
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $table = $type === 'hotel' ? 'bookings' : 'transport_bookings';
    $edit_booking = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM $table WHERE id=$edit_id AND user_id=$user_id"));
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - WanderLux</title>
    <link rel="stylesheet" href="../frontend/css/style.css">
        <style>
            body { 
                font-family: Arial, sans-serif; 
                margin:0; 
                padding:0; 
                background:#f2f2f2; 
            }
            .page-wrapper { 
                display:flex; 
                margin-top:60px; 
            }
            .main-content { 
                flex:1; 
                padding:40px; 
            }
            h1 { 
                text-align:center; 
                color:#333; 
                margin-bottom:30px; 
            }

            .booking-card { 
                background:#fdfdfd; 
                border-left:5px solid #6c5ce7; 
                margin-bottom:15px; 
                padding:15px 20px; 
                border-radius:10px; 
                box-shadow:0 2px 8px rgba(0,0,0,0.1); 
                width:100%; 
                text-align:left; 
            }
            .booking-card h4 { 
                margin:0 0 10px 0; 
                color:#584db1; 
            }
            .booking-card p { 
                margin:3px 0; 
                color:#333; 
            }
            .booking-card a { 
                margin-right:10px; 
                padding:5px 10px; 
                border-radius:5px; 
                background:#6c5ce7; 
                color:#fff; 
                text-decoration:none; 
                font-size:0.9rem; 
            }
            .booking-card a.delete { 
                background:#ff7675;
            }

            .edit-form { 
                background:#fff; 
                padding:20px; 
                border-radius:10px;
                box-shadow:0 2px 10px rgba(0,0,0,0.1); 
                margin-bottom:20px; 
                width:400px; 
            }
            .edit-form input { 
                width:100%; 
                padding:8px 10px; 
                margin-bottom:10px; 
                border-radius:5px; 
                border:1px solid #ccc; 
            }
            .edit-form button { 
                padding:8px 15px; 
                border:none; 
                border-radius:5px; 
                background:#6c5ce7; 
                color:#fff; 
                cursor:pointer; 
            }
            .edit-form button:hover { 
                background:#584db1; 
            }
        </style>
    </head>
<body>

<div class="page-wrapper">
    <div class="main-content">
        <h1>My Bookings</h1>

        <?php if ($edit_booking): ?>
            <div class="edit-form">
                <h3>Edit <?= ucfirst($type) ?> Booking</h3>
                <form method="POST" action="index.php?page=manageUserBooking&type=<?= $type ?>&edit_id=<?= $edit_booking['id'] ?>">
                    <?php if ($type === 'hotel'): ?>
                        <label>Check-in:</label>
                        <input type="date" name="check_in" value="<?= $edit_booking['check_in'] ?>" required>
                        <label>Check-out:</label>
                        <input type="date" name="check_out" value="<?= $edit_booking['check_out'] ?>" required>
                        <label>Guests:</label>
                        <input type="number" name="guests" value="<?= $edit_booking['guests'] ?>" min="1" required>
                    <?php else: ?>
                        <label>Travel Date:</label>
                        <input type="date" name="travel_date" value="<?= $edit_booking['travel_date'] ?>" required>
                        <label>guests:</label>
                        <input type="number" name="guests" value="<?= $edit_booking['guests'] ?>" min="1" required>
                    <?php endif; ?>
                    <input type="hidden" name="edit_id" value="<?= $edit_booking['id'] ?>">
                    <button type="submit" name="update_booking">Update Booking</button>
                </form>
            </div>
        <?php endif; ?>

        <!-- Booking List -->
        <h2><?= ucfirst($type) ?> Bookings</h2>
        <?php if (mysqli_num_rows($bookings) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($bookings)): ?>
                <div class="booking-card">
                    <h4><?= $type==='hotel' ? htmlspecialchars($row['hotel_name']) : htmlspecialchars($row['transport_name']) ?></h4>
                    <?php if ($type==='hotel'): ?>
                        <p>Check-in: <?= $row['check_in'] ?> | Check-out: <?= $row['check_out'] ?></p>
                        <p>Guests: <?= $row['guests'] ?> | Total: NPR <?= number_format($row['total_price'],2) ?></p>
                    <?php else: ?>
                        <p>Travel Date: <?= $row['travel_date'] ?></p>
                        <p>guests: <?= $row['guests'] ?> | Total: NPR <?= number_format($row['total_price'],2) ?></p>
                    <?php endif; ?>
                    <p>Status: <?= $row['status'] ?></p>
                    <a href="index.php?page=manageUserBooking&type=<?= $type ?>&edit_id=<?= $row['id'] ?>">Edit</a>
                    <a href="index.php?page=manageUserBooking&type=<?= $type ?>&delete_id=<?= $row['id'] ?>" class="delete" onclick="return confirm('Are you sure?')">Delete</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No <?= $type ?> bookings found.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
