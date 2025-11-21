<?php

include __DIR__ . '/../backend/connection.php';

$sql = "SELECT title, country, description, best_season, price_range, highlights, image_url FROM destinations";
$destinations = $conn->query($sql);

?>

<!DOCTYPE html>
<html>

<body>

    <div class="container">
        <h2>Favorite Destinations</h2>
        <div class="card-container">
            <?php foreach ($destinations as $dest): ?>
                <div class="card">
                    <img src="<?php echo htmlspecialchars($dest['image_url']); ?>" alt="<?php echo htmlspecialchars($dest['title']); ?>">
                    <div class="image-overlay">
                        <div class="card-title"><?php echo htmlspecialchars($dest['title']); ?></div>
                        <div class="card-location"><?php echo htmlspecialchars($dest['country']); ?></div>
                    </div>
                    <div class="card-body">
                        <span class="badge">Popular</span>
                        <div class="card-description"><?php echo htmlspecialchars($dest['description']); ?></div>
                        <div class="destination-details">
                            <span>🗓️ <?php echo htmlspecialchars($dest['best_season']); ?></span>
                            <span>💰 <?php echo htmlspecialchars($dest['price_range']); ?></span>
                        </div>
                        <div class="card-highlights">
                            <?php echo htmlspecialchars($dest['highlights']); ?>
                        </div>
                        <a href="index.php?page=hotels" class="explore-btn">Explore Destination</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>