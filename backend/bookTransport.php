<?php
session_start();

// Only logged-in users can book
if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['user', 'admin'])) {
    header("Location: ../index.php?page=loginPage");
    exit();
}

include __DIR__ . '/../backend/connection.php';

// Create transport_bookings table if missing
$createTableSQL = "
CREATE TABLE IF NOT EXISTS transport_bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    transport_id INT NOT NULL,
    travel_date DATE NOT NULL,
    guests INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'Pending'
)";
mysqli_query($conn, $createTableSQL);

// Messages
$error_message = '';
$success_message = '';

// Handle form submission
if (isset($_POST['book_transport'])) {
    $user_id = $_SESSION['user_id'];
    $transport_id = $_POST['transport_id'];
    $travel_date = $_POST['travel_date'];
    $guests = $_POST['guests'];

    // Validate travel date (no past date)
    if (strtotime($travel_date) < strtotime(date("Y-m-d"))) {
        $error_message = "Travel date cannot be in the past.";
    } else {
        // Fetch transport info
        $transport = mysqli_fetch_assoc(mysqli_query($conn, "SELECT price, name FROM transport WHERE id='$transport_id'"));

        if (!$transport) {
            $error_message = "Selected transport option not found.";
        } else {
            $total_price = $transport['price'] * $guests;

            // Insert booking
            $stmt = $conn->prepare("INSERT INTO transport_bookings (user_id, transport_id, travel_date, guests, total_price) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iisis", $user_id, $transport_id, $travel_date, $guests, $total_price);

            if ($stmt->execute()) {
                $success_message = "Booking successful for " . htmlspecialchars($transport['name']) . "! Total Price: NPR " . number_format($total_price, 2);
            } else {
                $error_message = "Booking failed: " . $stmt->error;
            }
        }
    }
}

// Fetch selected transport info
$transport_id = $_GET['transport_id'] ?? 1;
$transport = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM transport WHERE id='$transport_id'"));
if (!$transport) die("Transport not found.");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Transport - <?= htmlspecialchars($transport['name']) ?></title>
    <link rel="stylesheet" href="/projectI/frontend/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .booking-container {
            max-width: 600px;
            margin: 80px auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.1);
            border: 1px solid #ccc;
        }

        h2 {
            text-align: center;
            color: #6c5ce7;
            margin-bottom: 15px;
        }

        .price {
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
            color: #00b894;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        input[type="date"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #6c5ce7;
            color: white;
            font-size: 1rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #584db1;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #f5c6cb;
            text-align: center;
            margin-bottom: 20px;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #c3e6cb;
            text-align: center;
            margin-bottom: 20px;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #6c5ce7;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="booking-container">
    <h2>Book Transport: <?= htmlspecialchars($transport['name']) ?></h2>
    <p class="price">Price per day: NPR <?= number_format($transport['price'], 2) ?></p>

    <?php if (!empty($error_message)): ?>
        <div class="error-message"><?= $error_message ?></div>
    <?php endif; ?>

    <?php if (!empty($success_message)): ?>
        <div class="success-message"><?= $success_message ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="transport_id" value="<?= $transport['id'] ?>">

        <label>Travel Date:</label>
        <input type="date" name="travel_date" required min="<?= date('Y-m-d') ?>">

        <label>Number of Guests:</label>
        <input type="number" name="guests" value="1" min="1" required>

        <button type="submit" name="book_transport">Book Now</button>
    </form>

    <a class="back-link" href="index.php?page=transport">← Back to Transport Options</a>
</div>

</body>
</html>
