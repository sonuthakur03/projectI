<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../frontend/loginPage.php");
    exit();
}

include __DIR__ . '/../backend/connection.php';


$edit = false;
$editData = null;

if (isset($_GET['edit'])) {
    $edit = true;
    $id = $_GET['edit'];

    $result = mysqli_query($conn, "SELECT * FROM destinations WHERE id=$id");
    $editData = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title       = $_POST['title'];
    $country     = $_POST['country'];
    $description = $_POST['description'];
    $best        = $_POST['best_season'];
    $price       = $_POST['price_range'];
    $high        = $_POST['highlights'];
    $image       = $_POST['image_url'];

    // if editing → update
    if (isset($_POST['id']) && $_POST['id'] !== "") {
        $id = $_POST['id'];

        $sql = "UPDATE destinations SET 
            title='$title',
            country='$country',
            description='$description',
            best_season='$best',
            price_range='$price',
            highlights='$high',
            image_url='$image'
            WHERE id=$id";
    }
    // else → insert new
    else {
        $sql = "INSERT INTO destinations 
        (title, country, description, best_season, price_range, highlights, image_url)
        VALUES ('$title','$country','$description','$best','$price','$high','$image')";
    }

    mysqli_query($conn, $sql);

    // After saving, go back to manage page
    header("Location: index.php?page=manageDestinations");

    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $edit ? "Edit Destination" : "Add Destination" ?></title>
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
    <h2><?= $edit ? "Edit Destination" : "Add New Destination" ?></h2>

    <form method="POST">

        <!-- Hidden field for edit -->
        <?php if ($edit): ?>
            <input type="hidden" name="id" value="<?= $editData['id'] ?>">
        <?php endif; ?>

        <label>Title</label>
        <input type="text" name="title" required value="<?= $edit ? $editData['title'] : '' ?>">

        <label>Country</label>
        <input type="text" name="country" required value="<?= $edit ? $editData['country'] : '' ?>">

        <label>Description</label>
        <textarea name="description" rows="3"><?= $edit ? $editData['description'] : '' ?></textarea>

        <label>Best Season</label>
        <input type="text" name="best_season" required value="<?= $edit ? $editData['best_season'] : '' ?>">

        <label>Price Range</label>
        <input type="text" name="price_range" required value="<?= $edit ? $editData['price_range'] : '' ?>">

        <label>Highlights</label>
        <input type="text" name="highlights" required value="<?= $edit ? $editData['highlights'] : '' ?>">

        <label>Image URL</label>
        <input type="text" name="image_url" required value="<?= $edit ? $editData['image_url'] : '' ?>">

        <!-- Preview image if editing -->
        <?php if ($edit): ?>
            <img src="<?= $editData['image_url'] ?>">
        <?php endif; ?>

        <button type="submit"><?= $edit ? "Update" : "Add" ?></button>
    </form>
</div>

    <?php include __DIR__ . '/../frontend/footer.php'; ?>
</body>
</html>
