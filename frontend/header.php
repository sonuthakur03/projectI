<?php
// Do NOT start session here if index.php already has session_start()
?>

<!-- Navigation -->
<nav class="navbar">
    <div class="nav-container">

        <div class="logo">WanderLux</div>

        <ul class="nav-menu">

            <!-- Home -->
            <li>
                <a href="index.php?page=home">Home</a>
            </li>

            <!-- Hotels -->
            <li>
                <a href="index.php?page=hotels">Hotels</a>
            </li>

            <!-- Destinations -->
            <li>
                <a href="index.php?page=destinations">Destinations</a>
            </li>

            <!-- Transport -->
            <li>
                <a href="index.php?page=transport">Transport</a>
            </li>

            <!-- Dashboard (role-based) -->
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                <li>
                    <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <a href="index.php?page=adminDashboard">Admin Dashboard</a>
                    <?php else: ?>
                        <a href="index.php?page=userDashboard">User Dashboard</a>
                    <?php endif; ?>
                </li>
            <?php endif; ?>
        </ul>

        <!-- Login / Logout Buttons -->
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                <a href="index.php?page=logout" class="sign-in-btn">Logout</a>
        <?php else: ?>
            <div class="logButton">
                <a href="index.php?page=signupPage" class="btn-secondary">Sign Up</a>
                <a href="index.php?page=loginPage" class="btn-primary">Login</a>
            </div>
        <?php endif; ?>

    </div>
</nav>
