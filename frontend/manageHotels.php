<?php
include __DIR__ . '/../backend/connection.php';

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // sanitize input
    mysqli_query($conn, "DELETE FROM hotels WHERE id='$delete_id'");
    header("Location: index.php?page=manageHotels");
    exit();
}

// Fetch hotels
$result = mysqli_query($conn, "SELECT * FROM hotels ORDER BY id DESC");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Hotels</title>
    <link rel="stylesheet" href="../frontend/css/style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0px auto;
            padding: 0 20px;
            margin-top: 120px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .btn-add {
            display: inline-block;
            /* margin: 20px auto; */
            padding: 12px 20px;
            background: #2ecc71;
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            transition: 0.3s ease;
        }

        .btn-add:hover {
            background: #27ae60;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background: #6c5ce7;
            color: #fff;
            font-weight: 600;
        }

        tr {
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background: #f1f1f1;
        }

        td img {
            width: 100px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            color: #fff;
            transition: 0.3s ease;
        }

        .edit {
            background: #3498db;
        }

        .edit:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }

        .delete {
            background: #e74c3c;
        }

        .delete:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            table, tr, th, td {
                display: block;
            }
            th {
                text-align: right;
                padding-right: 50%;
            }
            td {
                padding-left: 50%;
                text-align: right;
            }
            td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: 45%;
                font-weight: bold;
                text-align: left;
            }
        }
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            width: 100%;
            text-align: right;
        }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="container">
        <div class="header-section">
            <h2>Manage Hotels</h2>
            <a href="index.php?page=hotelsForm" class="btn-add">Add New Hotel</a>
        </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Location</th>
            <th>Price</th>
            <th>Rating</th>
            <th>Reviews</th>
            <th>Type</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td data-label="ID"><?= $row['id'] ?></td>
                <td data-label="Name"><?= $row['name'] ?></td>
                <td data-label="Location"><?= $row['location'] ?></td>
                <td data-label="Price">Nrs.<?= $row['price'] ?></td>
                <td data-label="Rating"><?= $row['rating'] ?>/5</td>
                <td data-label="Reviews"><?= $row['reviews'] ?></td>
                <td data-label="Type"><?= $row['type'] ?></td>

                <td data-label="Image">
                    <img src="<?= $row['image_url'] ?>" alt="<?= $row['name'] ?>">
                </td>

                <td data-label="Actions" class="actions">
                    <a href="index.php?page=hotelsForm&edit=<?= $row['id'] ?>" class="btn edit">Edit</a>
                    <a href="index.php?page=manageHotels&delete_id=<?= $row['id'] ?>" class="btn delete" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php } ?>

    </table>
</div>

<?php include "footer.php"; ?>

</body>
</html>
