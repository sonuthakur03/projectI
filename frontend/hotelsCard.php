<?php
include __DIR__ . '/../backend/connection.php';

$destination = $_GET['destination'] ?? null;

if ($destination) {
    $stmt = $conn->prepare("SELECT * FROM hotels WHERE location = ?");
    $stmt->bind_param("s", $destination);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM hotels";
    $result = $conn->query($sql);
}
?>
<!-- Hotels -->
<section class="hotels">
    <h2>Hotels Found</h2>
    <div class="card-container">

        <?php if ($result->num_rows > 0): ?>

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
                            $link = "index.php?page=bookHotel&hotel_id=" . $row['id'];
                        } else {
                            $link = "index.php?page=loginPage";
                        }
                        ?>

                        <a href="<?php echo $link; ?>" class="book-btn">Book Now</a>
                    </div>
                </div>
            <?php endwhile; ?>

        <?php else: ?>

            <div class="no-hotels">
                <h3>No hotels found</h3>
                <p>We couldn't find any hotels for this destination yet.</p>
            </div>

        <?php endif; ?>

    </div>
</section>