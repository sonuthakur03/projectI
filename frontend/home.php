    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Discover Your Next<br><span class="highlight">Dream Destination</span></h1>
            <p>Experience luxury travel with curated hotels, expert guides, and unforgettable journeys around the world</p>
            <div class="hero-buttons">
                <a href="?page=hotels" class="btn-primary">Explore Hotels</a>
                <a href="?page=destinations" class="btn-secondary">View Destinations</a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="stats-container">
            <div class="stat-item animate-on-scroll">
                <div class="stat-number"></div>
                <div class="stat-label">Hotels Worldwide</div>
            </div>
            <div class="stat-item animate-on-scroll">
                <div class="stat-number">31</div>
                <div class="stat-label">Happy Travelers</div>
            </div>
            <div class="stat-item animate-on-scroll">
                <div class="stat-number"></div>
                <div class="stat-label">Countries Covered</div>
            </div>
            <div class="stat-item animate-on-scroll">
                <div class="stat-number">5</div>
                <div class="stat-label">Customer Rating</div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="features-container">
            <h2>Why Choose WanderLux?</h2>
            <p class="features-subtitle">We're committed to making your travel dreams come true with unmatched service, exclusive access, and personalized experiences.</p>

            <div class="features-grid">
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">🌍</div>
                    <h3>Global Coverage</h3>
                    <p>Access to premium hotels and destinations worldwide with our extensive network of exclusive deals.</p>
                </div>
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">🔒</div>
                    <h3>Secure Booking</h3>
                    <p>Protected payments and guaranteed reservations for peace of mind on every journey.</p>
                </div>
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">💎</div>
                    <h3>Personalized Service</h3>
                    <p>Tailored recommendations based on your preferences and travel history for unique experiences.</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Destinations Section -->
    <?php
    include './frontend/card.php'
    ?>


    <!-- CTA Section -->
    <section class="cta">
        <div class="cta-container">
            <h2>Ready to Start Your Adventure?</h2>
            <p>Join millions of travelers who trust WanderLux for their dream vacations. Book now and create memories that last a lifetime.</p>
            <div class="cta-buttons">
                <a href="?page=hotels" class="btn-primary">Find Hotels</a>
                <a href="index.php?page=signupPage" class="btn-secondary">Sign Up Free</a>
            </div>
        </div>
    </section>

        <?php include __DIR__ . "/footer.php"; ?>