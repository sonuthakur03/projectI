
<!-- Navigation -->
<nav class="navbar">
    <div class="nav-container">
        <div class="logo">WanderLux</div>
        <ul class="nav-menu">
            <li><a href="index.php?page=home">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-compass w-4 h-4">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon>
                    </svg>Home</a></li>
            <li><a href="index.php?page=hotels">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hotel w-4 h-4">
                        <path d="M18 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2Z"></path>
                        <path d="m9 16 .348-.24c1.465-1.013 3.84-1.013 5.304 0L15 16"></path>
                        <path d="M8 7h.01"></path>
                        <path d="M16 7h.01"></path>
                        <path d="M12 7h.01"></path>
                        <path d="M12 11h.01"></path>
                        <path d="M16 11h.01"></path>
                        <path d="M8 11h.01"></path>
                        <path d="M10 22v-6.5m4 0V22"></path>
                    </svg>Hotels</a></li>
            <li><a href="index.php?page=destinations">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map w-4 h-4">
                        <polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"></polygon>
                        <line x1="9" x2="9" y1="3" y2="18"></line>
                        <line x1="15" x2="15" y1="6" y2="21"></line>
                    </svg>Destinations</a></li>
            <li><a href="index.php?page=transport">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-car w-4 h-4">
                        <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9L18 10V6l-2-2H8l-2 2v4l-2.5 1.1C2.7 11.3 2 12.1 2 13v3c0 .6.4 1 1 1h2"></path>
                        <circle cx="7" cy="17" r="2"></circle>
                        <path d="M9 17h6"></path>
                        <circle cx="17" cy="17" r="2"></circle>
                    </svg>Transport</a></li>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                <li><a href="dashboard.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard w-4 h-4">
                            <rect width="7" height="9" x="3" y="3" rx="1"></rect>
                            <rect width="7" height="5" x="14" y="3" rx="1"></rect>
                            <rect width="7" height="9" x="14" y="12" rx="1"></rect>
                            <rect width="7" height="5" x="3" y="16" rx="1"></rect>
                        </svg> Dashboard</a>
                </li>
            <?php endif; ?>
        </ul>

<?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
    <!-- User is logged in -->
    <a href="logout.php" class="sign-in-btn">Logout</a>
<?php else: ?>
    <!-- User is not logged in -->
<div class="logButton">
    <a href="?page=signupPage" class="btn-secondary">Sign Up</a>
        <a href="?page=loginPage" class="btn-primary" style="margin-right: 10px;">Login</a>
</div>
<?php endif; ?>

    </div>
</nav>