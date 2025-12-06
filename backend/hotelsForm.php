<?php

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../frontend/loginPage.php");
    exit();
}

include __DIR__ . '/../backend/connection.php';

// Initialize edit mode
$edit = false;
$editData = null;

if (isset($_GET['edit'])) {
    $edit = true;
    $id = $_GET['edit'];

    $result = mysqli_query($conn, "SELECT * FROM hotels WHERE id=$id");
    $editData = mysqli_fetch_assoc($result);
}

// Validation functions
function textOnly($value) {
    return preg_match("/^[A-Za-z\s\.,\-]+$/", $value);
}

function validURL($value) {
    return filter_var($value, FILTER_VALIDATE_URL);
}

function numberOnly($value) {
    return is_numeric($value);
}

$errors = [];

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name       = $_POST['name'];
    $location   = $_POST['location'];
    $description= $_POST['description'];
    $price      = $_POST['price'];
    $rating     = $_POST['rating'];
    $reviews    = $_POST['reviews'];
    $type       = $_POST['type'];
    $image_url  = $_POST['image_url'];

    // VALIDATION
    if (!textOnly($name))        $errors[] = "Hotel name must contain letters only.";
    if (!textOnly($location))    $errors[] = "Location must contain letters only.";
    if (!numberOnly($price))     $errors[] = "Price must contain numbers only.";
    if ($rating !== "" && ($rating < 0 || $rating > 5)) 
                                $errors[] = "Rating must be between 0 and 5.";
    if ($reviews !== "" && !numberOnly($reviews))  
                                $errors[] = "Reviews must contain numbers only.";
    if (!textOnly($type))        $errors[] = "Hotel type must contain letters only.";
    if (!validURL($image_url))   $errors[] = "Image URL must be valid.";

    // If validation passes
    if (count($errors) === 0) {

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
        else {
            $sql = "INSERT INTO hotels 
            (name, location, description, price, rating, reviews, type, image_url)
            VALUES ('$name','$location','$description','$price','$rating','$reviews','$type','$image_url')";
        }

        mysqli_query($conn, $sql);

        header("Location: index.php?page=manageHotels");
        exit();
    }
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
        .error-box {
            background: #ffdede;
            color: #b30000;
            padding: 12px;
            border-left: 4px solid red;
            margin-bottom: 15px;
            border-radius: 6px;
        }
    </style>
</head>
<body>

<?php include __DIR__ . '/../frontend/header.php'; ?>

<div class="form-container">

    <h2><?= $edit ? "Edit Hotel" : "Add New Hotel" ?></h2>

    <?php if (!empty($errors)): ?>
        <div class="error-box">
            <?php foreach ($errors as $err): ?>
                <p><?= $err ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <?php if ($edit): ?>
            <input type="hidden" name="id" value="<?= $editData['id'] ?>">
        <?php endif; ?>

        <label>Hotel Name</label>
        <input type="text" name="name" required
               pattern="[A-Za-z\s\.,\-]+"
               value="<?= $edit ? $editData['name'] : '' ?>">

        <label>Location</label>
        <input type="text" name="location" required
               pattern="[A-Za-z\s\.,\-]+"
               value="<?= $edit ? $editData['location'] : '' ?>">

        <label>Description</label>
        <textarea name="description" rows="3"><?= $edit ? $editData['description'] : '' ?></textarea>

        <label>Price (NPR)</label>
        <input type="number" step="0.01" name="price" required
               value="<?= $edit ? $editData['price'] : '' ?>">

        <label>Rating (0 - 5)</label>
        <input type="number" step="0.1" min="0" max="5" name="rating"
               value="<?= $edit ? $editData['rating'] : '' ?>">

        <label>Number of Reviews</label>
        <input type="number" name="reviews"
               value="<?= $edit ? $editData['reviews'] : '' ?>">

        <label>Type (Luxury, Budget, etc.)</label>
        <input type="text" name="type"
               pattern="[A-Za-z\s\.,\-]+"
               value="<?= $edit ? $editData['type'] : '' ?>">

        <label>Image URL</label>
        <input type="text" name="image_url"
               value="<?= $edit ? $editData['image_url'] : '' ?>">

        <?php if ($edit): ?>
            <img src="<?= $editData['image_url'] ?>" alt="Hotel Image">
        <?php endif; ?>

        <button type="submit"><?= $edit ? "Update" : "Add" ?></button>

    </form>
</div>

<?php include __DIR__ . '/../frontend/footer.php'; ?>
</body>
</html>
