<!-- Navbar -->
<nav class="navbar">
    <div class="nav-container">

        <div class="logo"><a href="index.php?page=home" style="text-decoration: none; color: #2dd4bf;">WanderLux</a></div>

        <ul class="nav-menu">
            <li><a href="index.php?page=home" class="<?= ($_GET['page'] ?? 'home')==='home' ? 'active-link' : '' ?>">Home</a></li>
            <li><a href="index.php?page=hotels" class="<?= ($_GET['page'] ?? '')==='hotels' ? 'active-link' : '' ?>">Hotels</a></li>
            <li><a href="index.php?page=destinations" class="<?= ($_GET['page'] ?? '')==='destinations' ? 'active-link' : '' ?>">Destinations</a></li>
            <li><a href="index.php?page=transport" class="<?= ($_GET['page'] ?? '')==='transport' ? 'active-link' : '' ?>">Transport</a></li>

            <!-- Dashboard (role-based) -->
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                <li>
                    <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <a href="index.php?page=adminDashboard" class="<?= ($_GET['page'] ?? '')==='adminDashboard' ? 'active-link' : '' ?>">Admin Dashboard</a>
                    <?php else: ?>
                        <a href="index.php?page=userDashboard" class="<?= ($_GET['page'] ?? '')==='userDashboard' ? 'active-link' : '' ?>">User Dashboard</a>
                    <?php endif; ?>
                </li>
            <?php endif; ?>
        </ul>

        <!-- User avatar + logout -->
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
            <div class="user-actions">
                <div class="user-profile">
                    <span class="avatar"><?= strtoupper(substr($_SESSION['user_name'] ?? 'A',0,1)) ?></span>
                    <span class="username"><?= $_SESSION['user_name'] ?? 'User' ?></span>
                </div>
                <a href="index.php?page=logout" class="sign-in-btn">Logout</a>
            </div>
        <?php else: ?>
            <div class="logButton">
                <a href="index.php?page=signupPage" class="btn-secondary">Sign Up</a>
                <a href="index.php?page=loginPage" class="btn-primary">Login</a>
            </div>
        <?php endif; ?>

    </div>
</nav>