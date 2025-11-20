<?php

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../index.php?page=loginPage");
    exit();
}

include __DIR__ . '/../backend/connection.php';

// Read type
$type = $_GET['type'] ?? 'hotel';

// Handle delete
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $table = $type === 'hotel' ? 'bookings' : 'transport_bookings';
    mysqli_query($conn, "DELETE FROM $table WHERE id = $delete_id");
    header("Location: index.php?page=manageBooking&type=$type");
    exit();
}

// Handle approve
if (isset($_GET['approve_id'])) {
    $approve_id = intval($_GET['approve_id']);
    $table = $type === 'hotel' ? 'bookings' : 'transport_bookings';
    mysqli_query($conn, "UPDATE $table SET status='Confirmed' WHERE id=$approve_id");
    header("Location: index.php?page=manageBooking&type=$type");
    exit();
}

// Fetch bookings
if ($type === 'hotel') {
    $sql = "
        SELECT b.*, h.name AS hotel_name, u.name AS user_name
        FROM bookings b
        JOIN hotels h ON b.hotel_id = h.id
        JOIN users u ON b.user_id = u.id
    ";
} else {
    $sql = "
        SELECT t.*, tr.name AS transport_name, u.name AS user_name
        FROM transport_bookings t
        JOIN transport tr ON t.transport_id = tr.id
        JOIN users u ON t.user_id = u.id
    ";
}

$result = mysqli_query($conn, $sql);
?>

<div class="manage-container">
    <h2>Manage <?= ucfirst($type) ?> Bookings</h2>

    <div class="btn-group">
        <a href="index.php?page=manageBooking&type=hotel" class="btn <?= $type==='hotel'?'active':'' ?>">Hotel Bookings</a>
        <a href="index.php?page=manageBooking&type=transport" class="btn <?= $type==='transport'?'active':'' ?>">Transport Bookings</a>
    </div>

    <table class="booking-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th><?= $type === 'hotel' ? 'Hotel' : 'Transport' ?></th>
                <th><?= $type === 'hotel' ? 'Check-in' : 'Travel Date' ?></th>
                <th><?= $type === 'hotel' ? 'Check-out' : '---' ?></th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['user_name'] ?></td>
                <?php if ($type === 'hotel'): ?>
                    <td><?= $row['hotel_name'] ?></td>
                    <td><?= $row['check_in'] ?></td>
                    <td><?= $row['check_out'] ?></td>
                <?php else: ?>
                    <td><?= $row['transport_name'] ?></td>
                    <td><?= $row['travel_date'] ?></td>
                    <td>---</td>
                <?php endif; ?>
                <td><?= $row['total_price'] ?></td>
                <td class="status <?= strtolower($row['status']) ?>"><?= ucfirst($row['status']) ?></td>
                <td>
                    <?php if ($row['status'] === 'Pending'): ?>
                        <a href="index.php?page=manageBooking&type=<?= $type ?>&approve_id=<?= $row['id'] ?>"
                           onclick="return confirm('Approve this booking?')" class="btn-approve">
                           Approve
                        </a>
                    <?php endif; ?>
                    <a href="index.php?page=manageBooking&type=<?= $type ?>&delete_id=<?= $row['id'] ?>"
                       onclick="return confirm('Delete this booking?')" class="btn-delete">
                       Delete
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<style>
.manage-container { width: 95%; margin: 20px auto; font-family: Arial, sans-serif; }
h2 { text-align: center; margin-bottom: 20px; }
.btn-group { display: flex; justify-content: center; margin-bottom: 20px; gap: 10px; }
.btn { padding: 10px 20px; border-radius: 5px; background-color: #007bff; color: #fff; text-decoration: none; font-weight: bold; transition: 0.3s; }
.btn:hover { opacity: 0.8; }
.btn.active { background-color: #0056b3; }
.booking-table { width: 100%; border-collapse: collapse; }
.booking-table th, .booking-table td { border: 1px solid #ddd; padding: 12px; text-align: center; }
.booking-table th { background-color: #f4f4f4; }
.booking-table tr:nth-child(even) { background-color: #f9f9f9; }
.btn-delete { padding: 5px 10px; background-color: #dc3545; color: white; border-radius: 5px; text-decoration: none; margin-left: 5px; }
.btn-delete:hover { opacity: 0.8; }
.btn-approve { padding: 5px 10px; background-color: #28a745; color: white; border-radius: 5px; text-decoration: none; }
.btn-approve:hover { opacity: 0.8; }
/* Status colors */
.status.pending { color: orange; font-weight: bold; }
.status.confirmed { color: green; font-weight: bold; }
.status.cancelled { color: red; font-weight: bold; }
</style>
