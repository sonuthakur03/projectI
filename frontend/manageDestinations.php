<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../frontend/loginPage.php");
    exit();
}

include __DIR__ . '/../backend/connection.php';

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    mysqli_query($conn, "DELETE FROM destinations WHERE id='$delete_id'");
    header("Location: index.php?page=manageDestinations");
    exit();
}

// Fetch all destinations
$result = mysqli_query($conn, "SELECT * FROM destinations ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Destinations</title>
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
            transition: background 0.3s ease;
        }
        .btn-add:hover { background: #27ae60; }

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
    justify-content: center;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    height: 100%;
}

.btn {
    padding: 8px 16px;
    border-radius: 8px;
    font-weight: bold;
    text-decoration: none;
    color: #fff;
    transition: all 0.3s ease;
    box-shadow: 0 3px 6px rgba(0,0,0,0.15);
}

.edit {
    background: #3498db;
}

.edit:hover {
    background: #2980b9;
    transform: translateY(-2px);
    box-shadow: 0 5px 10px rgba(0,0,0,0.2);
}

.delete {
    background: #e74c3c;
}

.delete:hover {
    background: #c0392b;
    transform: translateY(-2px);
    box-shadow: 0 5px 10px rgba(0,0,0,0.2);
}


        @media (max-width: 768px) {
            table, tr, th, td {
                display: block;
            }
            th {
                text-align: right;
                padding-right: 50%;
                position: relative;
            }
            td {
                padding-left: 50%;
                text-align: right;
                position: relative;
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
    <?php include "header.php" ?>

<div class="container">
        <div class="header-section">
            <h2>Manage Destinations</h2>
            <a href="index.php?page=destinationsForm" class="btn-add">Add New Destination</a>
        </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Country</th>
            <th>Best Season</th>
            <th>Price Range</th>
            <th>Highlights</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td data-label="ID"><?= $row['id'] ?></td>
                <td data-label="Title"><?= $row['title'] ?></td>
                <td data-label="Country"><?= $row['country'] ?></td>
                <td data-label="Best Season"><?= $row['best_season'] ?></td>
                <td data-label="Price Range"><?= $row['price_range'] ?></td>
                <td data-label="Highlights"><?= $row['highlights'] ?></td>
                <td data-label="Image"><img src="<?= $row['image_url'] ?>" alt="<?= $row['title'] ?>"></td>
                <td data-label="Actions" class="actions">
                    <a href="index.php?page=destinationsForm&edit=<?= $row['id'] ?>" class="btn edit">Edit</a>
                    <a href="index.php?page=manageDestinations&delete_id=<?= $row['id'] ?>" 
                    class="btn delete" 
                    onclick="return confirm('Are you sure?')">
                    Delete
                    </a>

                </td>

            </tr>
            <?php } ?>
        </table>
</div>
    <?php include "footer.php" ?>
</body>
</html>
