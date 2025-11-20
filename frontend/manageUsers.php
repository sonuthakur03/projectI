<?php
include __DIR__ . '/../backend/connection.php';

// Check if user is admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../frontend/loginPage.php");
    exit();
}

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM users WHERE id='$delete_id'");
    header("Location: index.php?page=manageUsers");
    exit();
}

// Fetch all users
$result = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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
            margin: 0 auto;
            padding: 0 20px;
            margin: 80px auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
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
    <h2>Manage Users</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td data-label="ID"><?= $row['id'] ?></td>
                <td data-label="Name"><?= $row['name'] ?></td>
                <td data-label="Email"><?= $row['email'] ?></td>
                <td data-label="Role"><?= $row['role'] ?></td>

                <td data-label="Actions" class="actions">
                    <a href="index.php?page=editUser&edit=<?= $row['id'] ?>" class="btn edit">Edit</a>
                    <a href="index.php?page=manageUsers&delete_id=<?= $row['id'] ?>" class="btn delete" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                </td>
            </tr>
        <?php } ?>

    </table>
</div>

<?php include "footer.php"; ?>

</body>
</html>
