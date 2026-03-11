<?php
include __DIR__ . '/../backend/connection.php';

// Check if user is logged in
$loggedIn = isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], ['user', 'admin']);

// Read destination filter from GET
$fromLocation = $_GET['from_location'] ?? null;
$toLocation = $_GET['to_location'] ?? null;

// Fetch all unique locations dynamically
$locationsQuery = "SELECT DISTINCT from_location FROM transport
                   UNION
                   SELECT DISTINCT to_location FROM transport
                   ORDER BY from_location ASC";
$locationsResult = $conn->query($locationsQuery);

// Filter transport query
$filterConditions = [];
$params = [];
$types = "";

if ($fromLocation) {
    $filterConditions[] = "from_location = ?";
    $params[] = $fromLocation;
    $types .= "s";
}

if ($toLocation) {
    $filterConditions[] = "to_location = ?";
    $params[] = $toLocation;
    $types .= "s";
}

if ($filterConditions) {
    $sql = "SELECT * FROM transport WHERE " . implode(" AND ", $filterConditions);
    $stmt = $conn->prepare($sql);
    if ($params) $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM transport";
    $result = $conn->query($sql);
}
$selectedDestination = $_GET['destination'] ?? null;

// Fetch all destinations dynamically from the database
$destQuery = "SELECT DISTINCT title FROM destinations ORDER BY title ASC";
$destResult = $conn->query($destQuery);
?>

<!-- Transport Filter Form -->
<form method="GET" class="transport-filter">
    <input type="hidden" name="page" value="transport">

    <label class="filter-label" for="destination">Filter by Destination:</label>
    <select name="destination" id="destination">
        <option value="">All Destinations</option>
        <?php while($dest = $destResult->fetch_assoc()): ?>
            <option value="<?php echo htmlspecialchars($dest['title']); ?>"
                <?php if($selectedDestination == $dest['title']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($dest['title']); ?>
            </option>
        <?php endwhile; ?>
    </select>

    <button type="submit">Apply Filter</button>
</form>

<!-- Transport Cards -->
<section class="transport">
    <h2>Transport Options Found</h2>
    <div class="card-container">

        <?php if ($result->num_rows > 0): ?>

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

        <?php else: ?>

            <div class="no-transport">
                <h3>No transport found</h3>
                <p>No routes available for this destination.</p>
            </div>

        <?php endif; ?>

    </div>
</section>

<!-- Optional CSS -->
<style>
.transport-filter {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
    margin: 25px 0;
    padding: 10px 20px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
}

.transport-filter .filter-label {
    font-weight: bold;
    color: #333;
    margin-right: 5px;
    font-size: 1rem;
}

.transport-filter select {
    padding: 10px 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    background: #f8f8f8;
    transition: border 0.3s, box-shadow 0.3s;
}

.transport-filter select:focus {
    border-color: #6c5ce7;
    box-shadow: 0 0 8px rgba(108,92,231,0.3);
    outline: none;
}

.transport-filter button {
    padding: 10px 20px;
    background: linear-gradient(135deg, #6c5ce7, #00b894);
    color: #fff;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}

.transport-filter button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.2);
}
</style>