<?php
include __DIR__ . '/../backend/connection.php';

$sql = "SELECT * FROM hotels";
$result = $conn->query($sql);
?>
<!-- Hotels -->
<section class="hotels">
    <h2>Hotels Found</h2>
    <div class="card-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
                <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>">
                <div class="card-body">
                    <span class="badge"><?php echo $row['type']; ?></span>
                    <h3><?php echo $row['name']; ?></h3>
                    <p class="location"><?php echo $row['location']; ?></p>
                    <p class="desc"><?php echo $row['description']; ?></p>
                    <div class="price">NPR.<?php echo $row['price']; ?> <span>/ per night</span></div>
                    <div class="rating">⭐ <?php echo $row['rating']; ?> (<?php echo $row['reviews']; ?> reviews)</div>

                    <?php
                    if (isset($_SESSION['user_role'])) {
                        // User is logged in → go to booking page
                        $link = "index.php?page=bookHotel&hotel_id=" . $row['id'];
                    } else {
                        // Not logged in → go to login page
                        $link = "index.php?page=loginPage";
                    }
                    ?>
                    <a href="<?php echo $link; ?>" class="book-btn">Book Now</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</section>
