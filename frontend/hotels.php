<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        /* Hero */
        .herohotel {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url("https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80") center/cover no-repeat;
            color: #fff;
            text-align: center;
            padding: 50px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 75vh;
            flex-direction: column;
        }

        .herohotel h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .hotels {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .hotels h2 {
            font-size: 2.2rem;
            color: #222;
            margin-top: 10px;
        }

        /* Cards */
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 10px 20px;
        }

        .card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.48);
        }

        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .card-body {
            padding: 20px;
        }

        .badge {
            background: #0984e3;
            color: #fff;
            padding: 4px 8px;
            border-radius: 5px;
            font-size: 0.8rem;
        }

        .price {
            font-size: 1.2rem;
            font-weight: bold;
            margin: 10px 0;
        }

        .price span {
            font-size: 0.9rem;
            color: #777;
        }

        .book-btn {
            display: inline-block;
            margin-top: 15px;
            background: #00b894;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
        }

        .book-btn:hover {
            background: #019870;
        }
    </style>
</head>

<body>

    <?php include "header.php" ?>

    <!-- Hero -->
    <section class="herohotel">
        <h1>Discover Premium Hotels</h1>
        <p>From luxury resorts to boutique experiences, find your perfect stay with exclusive deals and expert recommendations.</p>
    </section>

    <?php include "hotelsCard.php" ?>

    <?php include "footer.php" ?>

</body>

</html>