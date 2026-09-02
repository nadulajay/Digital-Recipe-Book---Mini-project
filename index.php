<?php


require_once 'includes/db.php';
require_once 'includes/functions.php';

// Fetch recipes from database
try {
    $stmt = $pdo->query("SELECT * FROM recipes ORDER BY id DESC LIMIT 6");
    $recipes = $stmt->fetchAll();
} catch (PDOException $e) {
    $recipes = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlavorForge - A Digital Recipe Book | Home</title>
    <meta name="description" content="FlavorForge is your modern digital recipe book. Discover, filter, and master delicious recipes from around the world.">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Header & Navigation Bar -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <i class="bi bi-journal-richtext text-danger fs-3"></i>
                    [Logo] <span>FlavorForge</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">Recipes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact Us</a>
                        </li>
                    </ul>
                    <div class="d-flex gap-2">
                        <?php if (is_logged_in()): ?>
                            <span class="navbar-text fw-bold text-danger me-2">Hi, <?= htmlspecialchars($_SESSION['username']) ?></span>
                            <a href="auth/logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
                        <?php else: ?>
                            <a href="auth/login.php" class="btn btn-auth">
                                <i class="bi bi-person-circle me-1"></i> Login/Register
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content Area -->
    <main class="container my-4">

        <?php display_alerts(); ?>

        <!-- Hero Section - Bootstrap Carousel -->
        <section class="hero-section">
            <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <!-- Slide 1 -->
                    <div class="carousel-item active hero-carousel-item" style="background-image: url('pictures/photo-1555396273-367ea4eb4db5.avif');">
                        <div class="hero-overlay">
                            <div class="hero-card-content">
                                <h1>Discover & Forge Your Next Meal</h1>
                                <div class="hero-subtitle-box">
                                    [Full-width Background Image] Subtitle text + description goes here...
                                </div>
                                <div>
                                    <a href="dashboard.php" class="btn btn-hero-action me-2">Browse Recipes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="carousel-item hero-carousel-item" style="background-image: url('pictures/photo-1498837167922-ddd27525d352.avif');">
                        <div class="hero-overlay">
                            <div class="hero-card-content">
                                <h1>Master Culinary Arts At Home</h1>
                                <div class="hero-subtitle-box">
                                    Explore traditional Sri Lankan curries, Asian noodles & European desserts!
                                </div>
                                <div>
                                    <a href="dashboard.php" class="btn btn-hero-action me-2">Explore Categories</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 3 -->
                    <div class="carousel-item hero-carousel-item" style="background-image: url('pictures/photo-1504674900247-0877df9cc836.avif');">
                        <div class="hero-overlay">
                            <div class="hero-card-content">
                                <h1>Fresh Ingredients & Fast Recipes</h1>
                                <div class="hero-subtitle-box">
                                    Filter by cooking time, difficulty, and dietary choices effortlessly.
                                </div>
                                <div>
                                    <a href="dashboard.php" class="btn btn-hero-action me-2">Quick Meals (&lt;15 min)</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>

        <!-- Main Content - Recipe Grid Gallery -->
        <section class="my-5 text-center">
            <div class="section-title-box">
                Explore Popular Categories
            </div>

            <!-- Recipe Grid (3 Columns on Desktop, 2 on Tablet, 1 on Mobile) -->
            <div class="row g-4 text-start">
                
                <?php if (!empty($recipes)): ?>
                    <?php foreach ($recipes as $row): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="recipe-card">
                                <div class="recipe-img-container">
                                    <span class="badge-category"><?= htmlspecialchars($row['category']) ?></span>
                                    <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['title']) ?>" class="recipe-img">
                                </div>
                                <div class="recipe-card-body">
                                    <span class="badge-time"><i class="bi bi-clock me-1"></i> TIME: <?= htmlspecialchars($row['prep_time']) ?> mins</span>
                                    <h5 class="recipe-title"><?= htmlspecialchars($row['title']) ?></h5>
                                    <p class="recipe-desc"><?= htmlspecialchars(substr($row['instructions'], 0, 90)) ?>...</p>
                                    <button class="btn btn-view-recipe mt-auto" 
                                            data-bs-toggle="modal"
                                            data-bs-target="#recipeModal"
                                            data-recipe-id="<?= (int)$row['id'] ?>"
                                            data-title="<?= htmlspecialchars($row['title'], ENT_QUOTES) ?>"
                                            data-category="<?= htmlspecialchars($row['category'], ENT_QUOTES) ?>"
                                            data-time="<?= htmlspecialchars($row['prep_time'], ENT_QUOTES) ?> min"
                                            data-difficulty="<?= htmlspecialchars($row['difficulty'], ENT_QUOTES) ?>"
                                            data-image="<?= htmlspecialchars($row['image_url'], ENT_QUOTES) ?>"
                                            data-ingredients="<?= htmlspecialchars($row['ingredients'], ENT_QUOTES) ?>"
                                            data-instructions="<?= htmlspecialchars($row['instructions'], ENT_QUOTES) ?>"
                                            onclick="openRecipeModal(this)">
                                            View Recipe
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-4">
                        <p class="text-muted">No recipes found in database. Please run <code>database.sql</code> import script.</p>
                    </div>
                <?php endif; ?>

            </div>
        </section>

    </main>

    <!-- Inject MySQL Recipes directly into window.dbRecipes for instant JS lookup -->
    <script>
        window.dbRecipes = window.dbRecipes || {};
        <?php foreach ($recipes as $row): ?>
            window.dbRecipes[<?= (int)$row['id'] ?>] = <?= json_encode([
                'id'           => (int)$row['id'],
                'title'        => $row['title'],
                'category'     => $row['category'],
                'time'         => $row['prep_time'] . ' mins',
                'difficulty'   => $row['difficulty'],
                'image'        => $row['image_url'] ?: 'pictures/photo-1498837167922-ddd27525d352.avif',
                'ingredients'  => array_values(array_filter(array_map('trim', explode("\n", $row['ingredients'])))),
                'instructions' => array_values(array_filter(array_map('trim', explode("\n", $row['instructions']))))
            ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
        <?php endforeach; ?>
    </script>

    <!-- Footer Component -->
    <footer class="footer-custom">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">[LOGO] FlavorForge</div>
                    <p class="text-muted small mb-3">(Brand Description)</p>
                    <p class="small">FlavorForge is an interactive digital recipe workspace developed for home cooks and culinary lovers.</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-title">Quick Links</h6>
                    <ul class="footer-links">
                        <li><a href="index.php">&gt; Home</a></li>
                        <li><a href="dashboard.php">&gt; Recipes</a></li>
                        <li><a href="dashboard.php">&gt; Categories</a></li>
                        <li><a href="contact.php">&gt; Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="footer-title">Categories</h6>
                    <ul class="footer-links">
                        <li><a href="dashboard.php">&gt; Breakfast</a></li>
                        <li><a href="dashboard.php">&gt; Lunch</a></li>
                        <li><a href="dashboard.php">&gt; Dinner</a></li>
                        <li><a href="dashboard.php">&gt; Dessert</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-title">Newsletter</h6>
                    <form id="newsletter-form">
                        <input type="email" id="newsletter-email" class="form-control newsletter-input" placeholder="[ Email Input ]" required>
                        <button type="submit" id="newsletter-submit" class="btn btn-subscribe">[ Subscribe ]</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; 2026 FlavorForge. All Rights Reserved. | <a href="#" class="text-secondary text-decoration-none">Social Links</a> | <a href="#" class="text-secondary text-decoration-none">Privacy Policy</a>
            </div>
        </div>
    </footer>

    <!-- Recipe Detail Interactive Modal -->
    <div class="modal fade" id="recipeModal" tabindex="-1" aria-labelledby="recipeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title modal-recipe-title" id="recipeModalLabel">Recipe Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-5">
                            <img id="modalRecipeImage" src="" alt="Recipe" class="img-fluid rounded-3 shadow-sm mb-3 w-100">
                            <div class="p-3 bg-light rounded-3 border">
                                <div class="mb-2"><strong>Category:</strong> <span id="modalRecipeCategory" class="badge bg-secondary"></span></div>
                                <div class="mb-2"><strong>Prep & Cook Time:</strong> <span id="modalRecipeTime" class="text-danger fw-bold"></span></div>
                                <div><strong>Difficulty:</strong> <span id="modalRecipeDifficulty" class="badge bg-info text-dark"></span></div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h6 class="fw-bold border-bottom pb-2 text-danger"><i class="bi bi-basket me-2"></i>Ingredients</h6>
                            <ul id="modalRecipeIngredients" class="list-unstyled mb-4">
                                <!-- Dynamic List -->
                            </ul>
                            
                            <h6 class="fw-bold border-bottom pb-2 text-danger"><i class="bi bi-list-ol me-2"></i>Cooking Instructions</h6>
                            <div id="modalRecipeInstructions">
                                <!-- Dynamic Steps -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="contact.php" class="btn btn-danger">Ask Chef Questions</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
