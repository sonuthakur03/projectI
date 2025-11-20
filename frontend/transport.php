<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        /* Hero */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url("https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80") center/cover no-repeat;
            color: #fff;
            text-align: center;
            padding: 50px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 75vh;
            flex-direction: column;
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .transport {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .transport h2 {
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
            background: #6c5ce7;
            color: #fff;
            padding: 4px 8px;
            border-radius: 5px;
            font-size: 0.8rem;
        }

        .route {
            font-weight: bold;
            color: #666;
            margin: 8px 0;
            font-size: 1rem;
        }

        .route::before {
            content: "📍";
            margin-right: 5px;
        }

        .transport-details {
            display: flex;
            justify-content: space-between;
            margin: 12px 0;
            font-size: 14px;
            color: #777;
        }

        .transport-details span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .price {
            font-size: 1.2rem;
            font-weight: bold;
            margin: 10px 0;
            color: #e17055;
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

        .desc {
            color: #666;
            margin: 8px 0;
            line-height: 1.4;
        }

        .rating {
            color: #f39c12;
            font-size: 0.9rem;
            margin: 8px 0;
        }
    </style>
</head>

<body>

    <?php include "header.php" ?>

    <!-- Hero -->
    <section class="hero">
        <h1>Reliable Transport Solutions</h1>
        <p>From buses and flights to car rentals and helicopter tours, find convenient and safe transport options for your journey across Nepal.</p>
    </section>

    <?php include "transportCard.php" ?>

    <?php include "footer.php" ?>

</body>

</html>