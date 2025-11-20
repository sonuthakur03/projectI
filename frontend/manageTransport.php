<?php
include __DIR__ . '/../backend/connection.php';

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // sanitize
    mysqli_query($conn, "DELETE FROM transport WHERE id='$delete_id'");
    header("Location: index.php?page=manageTransport");
    exit();
}

// Fetch transport records
$result = mysqli_query($conn, "SELECT * FROM transport ORDER BY id DESC");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Transport</title>
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
            margin: 20px auto;
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
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="container">
    <h2>Manage Transport</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>From</th>
            <th>To</th>
            <th>Price</th>
            <th>Rating</th>
            <th>Reviews</th>
            <th>Type</th>
            <th>Duration</th>
            <th>Departure</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td data-label="ID"><?= $row['id'] ?></td>
                <td data-label="Name"><?= $row['name'] ?></td>
                <td data-label="From"><?= $row['from_location'] ?></td>
                <td data-label="To"><?= $row['to_location'] ?></td>
                <td data-label="Price">Rs <?= $row['price'] ?></td>
                <td data-label="Rating"><?= $row['rating'] ?>/5</td>
                <td data-label="Reviews"><?= $row['reviews'] ?></td>
                <td data-label="Type"><?= $row['type'] ?></td>
                <td data-label="Duration"><?= $row['duration'] ?></td>
                <td data-label="Departure"><?= $row['departure_time'] ?></td>
                <td data-label="Image"><img src="<?= $row['image_url'] ?>" alt="<?= $row['name'] ?>"></td>

                <td data-label="Actions" class="actions">
                    <a href="index.php?page=transportForm&edit=<?= $row['id'] ?>" class="btn edit">Edit</a>
                    <a href="index.php?page=manageTransport&delete_id=<?= $row['id'] ?>" class="btn delete" onclick="return confirm('Are you sure?')">Delete</a>

                </td>
            </tr>
        <?php } ?>

    </table>

    <a href="index.php?page=transportForm" class="btn-add">Add New Transport</a>
</div>

<?php include "footer.php"; ?>

</body>
</html>
