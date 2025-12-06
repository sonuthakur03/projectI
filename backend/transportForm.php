<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../frontend/loginPage.php");
    exit();
}

include __DIR__ . '/../backend/connection.php';

// Initialize variables for edit
$edit = false;
$editData = null;

if (isset($_GET['edit'])) {
    $edit = true;
    $id = $_GET['edit'];

    $result = mysqli_query($conn, "SELECT * FROM transport WHERE id=$id");
    $editData = mysqli_fetch_assoc($result);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $from_location = $_POST['from_location'];
    $to_location = $_POST['to_location'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $rating = $_POST['rating'];
    $reviews = $_POST['reviews'];
    $type = $_POST['type'];
    $duration = $_POST['duration'];
    $departure_time = $_POST['departure_time'];
    $image_url = $_POST['image_url'];

    // Update if editing
    if (isset($_POST['id']) && $_POST['id'] !== "") {
        $id = $_POST['id'];
        $sql = "UPDATE transport SET
            name='$name',
            from_location='$from_location',
            to_location='$to_location',
            description='$description',
            price='$price',
            rating='$rating',
            reviews='$reviews',
            type='$type',
            duration='$duration',
            departure_time='$departure_time',
            image_url='$image_url'
            WHERE id=$id";
    } 
    // Insert new
    else {
        $sql = "INSERT INTO transport 
        (name, from_location, to_location, description, price, rating, reviews, type, duration, departure_time, image_url)
        VALUES ('$name','$from_location','$to_location','$description','$price','$rating','$reviews','$type','$duration','$departure_time','$image_url')";
    }

    mysqli_query($conn, $sql);

    // Redirect after saving
    header("Location: index.php?page=manageTransport");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $edit ? "Edit Transport" : "Add Transport" ?></title>
    <link rel="stylesheet" href="/projectI/frontend/css/style.css">
    <style>
        .form-container {
            max-width: 800px;
            margin: 60px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border: 1px solid #000;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .location-row {
            display: flex;
            gap: 15px;
        }
        .location-row > div {
            flex: 1;
        }
        button {
            padding: 12px 20px;
            background: #20c997;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover { background: #148865; }
        img { 
            max-width: 180px; 
            border-radius: 10px; 
            margin-top: 10px; 
        }
    </style>
</head>
<body>

<?php include __DIR__ . '/../frontend/header.php'; ?>

<div class="form-container">
    <h2><?= $edit ? "Edit Transport" : "Add New Transport" ?></h2>

    <form method="POST">
        <?php if ($edit): ?>
            <input type="hidden" name="id" value="<?= $editData['id'] ?>">
        <?php endif; ?>

        <label>Transport Service Name</label>
        <input type="text" name="name" required value="<?= $edit ? $editData['name'] : '' ?>">

        <div class="location-row">
            <div>
                <label>From</label>
                <input type="text" name="from_location" required value="<?= $edit ? $editData['from_location'] : '' ?>">
            </div>
            <div>
                <label>To</label>
                <input type="text" name="to_location" required value="<?= $edit ? $editData['to_location'] : '' ?>">
            </div>
        </div>

        <label>Description</label>
        <textarea name="description" rows="3"><?= $edit ? $editData['description'] : '' ?></textarea>

        <label>Price (NPR)</label>
        <input type="number" step="0.01" name="price" required value="<?= $edit ? $editData['price'] : '' ?>">

        <label>Rating</label>
        <input type="number" step="0.1" min="0" max="5" name="rating" value="<?= $edit ? $editData['rating'] : '' ?>">

        <label>Number of Reviews</label>
        <input type="number" name="reviews" value="<?= $edit ? $editData['reviews'] : '' ?>">

        <label>Transport Type</label>
        <select name="type">
            <option value="">Select type</option>
            <?php 
            $types = ['Bus', 'Car Rental', 'Taxi', 'Motorcycle', 'Jeep'];
            foreach ($types as $t) {
                $selected = ($edit && $editData['type'] === $t) ? 'selected' : '';
                echo "<option value='$t' $selected>$t</option>";
            }
            ?>
        </select>

        <label>Duration</label>
        <input type="text" name="duration" value="<?= $edit ? $editData['duration'] : '' ?>">

        <label>Departure Time</label>
        <input type="text" name="departure_time" value="<?= $edit ? $editData['departure_time'] : '' ?>">

        <label>Image URL</label>
        <input type="text" name="image_url" value="<?= $edit ? $editData['image_url'] : '' ?>">

        <?php if ($edit): ?>
            <img src="<?= $editData['image_url'] ?>" alt="Transport Image">
        <?php endif; ?>

        <button type="submit"><?= $edit ? "Update" : "Add" ?></button>
    </form>
</div>

<?php include __DIR__ . '/../frontend/footer.php'; ?>

</body>
</html>
