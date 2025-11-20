<?php
include __DIR__ . '/../backend/connection.php';

// Check if user is logged in
$loggedIn = isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], ['user', 'admin']);

$sql = "SELECT * FROM transport";
$result = $conn->query($sql);
?>
<!-- Transport -->
<section class="transport">
    <h2>Transport Options Found</h2>
    <div class="card-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
                <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>">
                <div class="card-body">
                    <span class="badge"><?php echo $row['type']; ?></span>
                    <h3><?php echo $row['name']; ?></h3>
                    <p class="route"><?php echo $row['from_location']; ?> → <?php echo $row['to_location']; ?></p>
                    <p class="desc"><?php echo $row['description']; ?></p>
                    <div class="transport-details">
                        <span class="duration">⏱️ <?php echo $row['duration']; ?></span>
                        <span class="departure">🕒 <?php echo $row['departure_time']; ?></span>
                    </div>
                    <div class="price">NPR <?php echo $row['price']; ?> <span>/ per day</span></div>
                    <div class="rating">⭐ <?php echo $row['rating']; ?> (<?php echo $row['reviews']; ?> reviews)</div>

                    <?php if ($loggedIn): ?>
                        <a href="index.php?page=bookTransport&transport_id=<?php echo $row['id']; ?>" class="book-btn">Book Now</a>
                    <?php else: ?>
                        <a href="index.php?page=loginPage" class="book-btn">Login to Book</a>
                    <?php endif; ?>

                </div>
            </div>
        <?php endwhile; ?>
    </div>
</section>
