<?php
session_start();
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

    $result = mysqli_query($conn, "SELECT * FROM hotels WHERE id=$id");
    $editData = mysqli_fetch_assoc($result);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $rating = $_POST['rating'];
    $reviews = $_POST['reviews'];
    $type = $_POST['type'];
    $image_url = $_POST['image_url'];

    // Update if editing
    if (isset($_POST['id']) && $_POST['id'] !== "") {
        $id = $_POST['id'];
        $sql = "UPDATE hotels SET
            name='$name',
            location='$location',
            description='$description',
            price='$price',
            rating='$rating',
            reviews='$reviews',
            type='$type',
            image_url='$image_url'
            WHERE id=$id";
    } 
    // Insert new
    else {
        $sql = "INSERT INTO hotels 
        (name, location, description, price, rating, reviews, type, image_url)
        VALUES ('$name','$location','$description','$price','$rating','$reviews','$type','$image_url')";
    }

    mysqli_query($conn, $sql);

    // Redirect after saving
    header("Location: index.php?page=manageHotels");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $edit ? "Edit Hotel" : "Add Hotel" ?></title>
    <link rel="stylesheet" href="/projectI/frontend/css/style.css">
    <style>
        .form-container {
            max-width: 700px;
            margin: 60px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border: 1px solid #000000ff;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
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
        img { max-width: 180px; border-radius: 10px; margin-top: 10px; }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../frontend/header.php'; ?>

    <div class="form-container">
        <h2><?= $edit ? "Edit Hotel" : "Add New Hotel" ?></h2>

        <form method="POST">
            <?php if ($edit): ?>
                <input type="hidden" name="id" value="<?= $editData['id'] ?>">
            <?php endif; ?>

            <label>Hotel Name</label>
            <input type="text" name="name" required value="<?= $edit ? $editData['name'] : '' ?>">

            <label>Location</label>
            <input type="text" name="location" required value="<?= $edit ? $editData['location'] : '' ?>">

            <label>Description</label>
            <textarea name="description" rows="3"><?= $edit ? $editData['description'] : '' ?></textarea>

            <label>Price (NPR)</label>
            <input type="number" step="0.01" name="price" required value="<?= $edit ? $editData['price'] : '' ?>">

            <label>Rating</label>
            <input type="number" step="0.1" name="rating" value="<?= $edit ? $editData['rating'] : '' ?>">

            <label>Number of Reviews</label>
            <input type="number" name="reviews" value="<?= $edit ? $editData['reviews'] : '' ?>">

            <label>Type</label>
            <input type="text" name="type" placeholder="Luxury, Budget, Resort, etc." value="<?= $edit ? $editData['type'] : '' ?>">

            <label>Image URL</label>
            <input type="text" name="image_url" value="<?= $edit ? $editData['image_url'] : '' ?>">

            <?php if ($edit): ?>
                <img src="<?= $editData['image_url'] ?>" alt="Hotel Image">
            <?php endif; ?>

            <button type="submit"><?= $edit ? "Update" : "Add" ?></button>
        </form>
    </div>

    <?php include __DIR__ . '/../frontend/footer.php'; ?>
</body>
</html>
