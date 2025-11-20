<?php

// Allow only logged-in users (user or admin)
if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['user', 'admin'])) {
    header("Location: ../index.php?page=loginPage");
    exit();
}

include __DIR__ . '/../backend/connection.php';

// 1️⃣ Create bookings table if it doesn't exist
$createTableSQL = "
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    hotel_id INT NOT NULL,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    guests INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'Pending'
)
";

if (!mysqli_query($conn, $createTableSQL)) {
    die("Error creating bookings table: " . mysqli_error($conn));
}

// 2️⃣ Handle form submission
$success_message = '';
if (isset($_POST['book_hotel'])) {
    $user_id = $_SESSION['user_id'];
    $hotel_id = $_POST['hotel_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $guests = $_POST['guests'];

    // Fetch hotel
    $hotel = mysqli_fetch_assoc(mysqli_query($conn, "SELECT price, name FROM hotels WHERE id='$hotel_id'"));
    if (!$hotel) die("Hotel not found.");

    $nights = (new DateTime($check_out))->diff(new DateTime($check_in))->days;
    if ($nights <= 0) die("Check-out must be after check-in.");

    $total_price = $nights * $hotel['price'] * $guests;

    $stmt = $conn->prepare("INSERT INTO bookings (user_id, hotel_id, check_in, check_out, guests, total_price) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissid", $user_id, $hotel_id, $check_in, $check_out, $guests, $total_price);
    if ($stmt->execute()) {
        $success_message = "Booking successful for " . htmlspecialchars($hotel['name']) . "! Total Price: NPR." . number_format($total_price, 2);
    } else {
        $success_message = "Booking failed: " . $stmt->error;
    }
}

// 3️⃣ Show hotel info
$hotel_id = $_GET['hotel_id'] ?? 1;
$hotel = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM hotels WHERE id='$hotel_id'"));
if (!$hotel) die("Hotel not found.");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Book Hotel - <?= htmlspecialchars($hotel['name']) ?></title>
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
    margin: 50px auto;
    background: #fff;
    padding: 30px 40px;
    border-radius: 15px;
    box-shadow: 0 6px 25px rgba(0,0,0,0.1);
    border: 1px solid #ccc;
    margin-top: 120px;
}

h2 {
    text-align: center;
    color: #6c5ce7;
    margin-bottom: 15px;
}

p.price {
    text-align: center;
    font-size: 1.2rem;
    font-weight: bold;
    color: #00b894;
    margin-bottom: 25px;
}

form label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #333;
}

form input[type="date"],
form input[type="number"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 1rem;
}

form button {
    width: 100%;
    padding: 12px;
    background: #6c5ce7;
    color: #fff;
    font-size: 1rem;
    font-weight: bold;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: background 0.3s ease;
}

form button:hover {
    background: #584db1;
}

.success-message {
    background: #d4edda;
    color: #155724;
    text-align: center;
    padding: 15px;
    border-radius: 10px;
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
    <h2>Book Hotel: <?= htmlspecialchars($hotel['name']) ?></h2>
    <p class="price">Price per night: NPR.<?= number_format($hotel['price'], 2) ?></p>

    <?php if ($success_message): ?>
        <div class="success-message"><?= $success_message ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="hotel_id" value="<?= $hotel['id'] ?>">

        <label>Check-in Date:</label>
        <input type="date" name="check_in" required>

        <label>Check-out Date:</label>
        <input type="date" name="check_out" required>

        <label>Guests:</label>
        <input type="number" name="guests" value="1" min="1" required>

        <button type="submit" name="book_hotel">Book Now</button>
    </form>

    <a class="back-link" href="index.php?page=hotels">← Back to Hotels</a>
</div>
</body>
</html>
