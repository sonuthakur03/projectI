<?php
// database connection
include './backend/connection.php';

$sql = "SELECT title, country, description, image_url FROM destinations LIMIT 3";
$result = $conn->query($sql);
?>

<section class="destinationsCard" id="destinations">
    <div class="destinations-container">
        <h2>Popular Destinations</h2>
        <p class="destinations-subtitle">Discover the world's most breathtaking locations with our expert travel guides.</p>

        <div class="destinations-grid">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="destination-card" style="background-image:url('<?php echo $row['image_url']; ?>');">
                    <div class="destination-info">
                        <h3><?php echo $row['title']; ?>, <?php echo $row['country']; ?></h3>
                        <p><?php echo $row['description']; ?></p>
                    </div>
                </div>

            <?php } ?>
        </div>

        <a href="?page=destinations" class="btn-primary">Explore All Destinations</a>
    </div>
</section>