<?php


require_once 'includes/db.php';
require_once 'includes/functions.php';

// Fetch all recipes from MySQL database
try {
    $stmt = $pdo->query("SELECT * FROM recipes ORDER BY id DESC");
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
    <title>FlavorForge - Recipe Dashboard & Search Feed</title>
    <meta name="description" content="Search and filter delicious digital recipes by category, cooking time, and difficulty in real time.">
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
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="dashboard.php">Recipes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact Us</a>
                        </li>
                    </ul>
                    <div class="d-flex gap-2 align-items-center">
                        <?php if (is_logged_in()): ?>
                            <button class="btn btn-danger btn-sm fw-bold me-2" data-bs-toggle="modal" data-bs-target="#addRecipeModal">
                                <i class="bi bi-plus-circle me-1"></i> Add Recipe
                            </button>
                            <span class="navbar-text fw-bold text-dark small me-2">Hi, <?= htmlspecialchars($_SESSION['username']) ?></span>
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

    <!-- Main Content Area - Recipe Dashboard Layout -->
    <main class="container my-4">

        <?php display_alerts(); ?>

        <div class="row g-4">

            <!-- SIDEBAR (Filters Area) -->
            <aside class="col-lg-3 col-md-4">
                <div class="filter-sidebar">
                    
                    <!-- Search Input Box -->
                    <div class="mb-4">
                        <label for="searchQuery" class="form-label fw-bold text-secondary small">SIDEBAR (Filters)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" id="searchQuery" class="form-control search-input-custom border-start-0" placeholder="Search...">
                        </div>
                    </div>

                    <!-- Category Filter Header & Checkboxes -->
                    <div class="mb-4">
                        <div class="filter-header-badge">Category</div>
                        <div class="form-check mb-2">
                            <input class="form-check-input category-check" type="checkbox" value="Breakfast" id="catBreakfast">
                            <label class="form-check-label small fw-semibold" for="catBreakfast">[ ] Breakfast</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input category-check" type="checkbox" value="Lunch" id="catLunch">
                            <label class="form-check-label small fw-semibold" for="catLunch">[ ] Lunch</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input category-check" type="checkbox" value="Dinner" id="catDinner">
                            <label class="form-check-label small fw-semibold" for="catDinner">[ ] Dinner</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input category-check" type="checkbox" value="Dessert" id="catDessert">
                            <label class="form-check-label small fw-semibold" for="catDessert">[ ] Dessert</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input category-check" type="checkbox" value="Seafood" id="catSeafood">
                            <label class="form-check-label small fw-semibold" for="catSeafood">[ ] Seafood</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input category-check" type="checkbox" value="Vegan" id="catVegan">
                            <label class="form-check-label small fw-semibold" for="catVegan">[ ] Vegan</label>
                        </div>
                    </div>

                    <!-- Cooking Time Header & Range Selector -->
                    <div class="mb-4">
                        <div class="filter-header-badge">Cooking Time</div>
                        <div class="text-center mb-2">
                            <span id="timeValueLabel" class="badge bg-danger text-white px-3 py-1 fw-bold">&lt; 120 min</span>
                        </div>
                        <input type="range" class="form-range" id="timeRangeSlider" min="10" max="120" step="5" value="120">
                        <div class="d-flex justify-content-between text-muted small fw-bold mt-1">
                            <span>0</span>
                            <span>120+</span>
                        </div>

                        <!-- Quick Filters -->
                        <div class="mt-3">
                            <div class="small fw-bold text-muted mb-2">Quick Filters:</div>
                            <button type="button" class="quick-filter-btn" data-time-limit="15">&lt;15 min</button>
                            <button type="button" class="quick-filter-btn" data-time-limit="30">&lt;30 min</button>
                            <button type="button" class="quick-filter-btn" data-time-limit="45">&lt;45 min</button>
                            <button type="button" class="quick-filter-btn" data-time-limit="60">&lt;60 min</button>
                        </div>
                    </div>

                    <!-- Difficulty Checks -->
                    <div class="mb-4">
                        <div class="filter-header-badge">Difficulty</div>
                        <div class="form-check mb-2">
                            <input class="form-check-input difficulty-check" type="checkbox" value="Easy" id="diffEasy">
                            <label class="form-check-label small fw-semibold" for="diffEasy">[ ] Easy</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input difficulty-check" type="checkbox" value="Medium" id="diffMedium">
                            <label class="form-check-label small fw-semibold" for="diffMedium">[ ] Medium</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input difficulty-check" type="checkbox" value="Hard" id="diffHard">
                            <label class="form-check-label small fw-semibold" for="diffHard">[ ] Hard</label>
                        </div>
                    </div>

                    <!-- Reset Filters Button -->
                    <button type="button" id="resetFilters" class="btn btn-reset-filters mb-4">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Clear All Filters
                    </button>

                    <!-- Popular Tags -->
                    <div>
                        <div class="filter-header-badge">Popular Tags</div>
                        <div>
                            <span class="tag-pill">#Chicken</span>
                            <span class="tag-pill">#Vegan</span>
                            <span class="tag-pill">#Quick</span>
                            <span class="tag-pill">#Healthy</span>
                            <span class="tag-pill">#Spicy</span>
                            <span class="tag-pill">#Sweet</span>
                        </div>
                    </div>

                </div>
            </aside>

            <!-- DYNAMIC CONTENT AREA -->
            <section class="col-lg-9 col-md-8">
                
                <!-- Result Count Header -->
                <div class="bg-light p-3 rounded-3 border mb-4 d-flex justify-content-between align-items-center">
                    <h5 id="resultCountHeading" class="fw-bold mb-0 text-secondary">Showing: All Recipes (<?= count($recipes) ?> results)</h5>
                    <?php if (is_logged_in()): ?>
                        <button class="btn btn-sm btn-danger fw-bold" data-bs-toggle="modal" data-bs-target="#addRecipeModal">
                            <i class="bi bi-plus-lg me-1"></i> Submit New Recipe
                        </button>
                    <?php endif; ?>
                </div>

                <!-- Recipe Cards Workspace Grid -->
                <div class="row g-4" id="recipeWorkspace">

                    <?php if (!empty($recipes)): ?>
                        <?php foreach ($recipes as $r): ?>
                            <div class="col-lg-4 col-md-6 recipe-grid-item" 
                                 data-title="<?= htmlspecialchars($r['title']) ?>" 
                                 data-category="<?= htmlspecialchars($r['category']) ?>" 
                                 data-difficulty="<?= htmlspecialchars($r['difficulty']) ?>" 
                                 data-time="<?= htmlspecialchars($r['prep_time']) ?>" 
                                 data-tags="<?= htmlspecialchars(strtolower($r['title'] . ' ' . $r['category'] . ' ' . $r['ingredients'])) ?>">
                                
                                <div class="recipe-card">
                                    <div class="recipe-img-container">
                                        <span class="badge-category"><?= htmlspecialchars($r['category']) ?></span>
                                        <img src="<?= htmlspecialchars($r['image_url']) ?>" alt="<?= htmlspecialchars($r['title']) ?>" class="recipe-img">
                                    </div>
                                    <div class="recipe-card-body">
                                        <h6 class="recipe-title"><?= htmlspecialchars($r['title']) ?></h6>
                                        <p class="small text-muted mb-2">Time: <?= htmlspecialchars($r['prep_time']) ?> min | <?= htmlspecialchars($r['difficulty']) ?></p>
                                        <button class="btn btn-view-recipe mt-auto" 
                                                data-bs-toggle="modal"
                                                data-bs-target="#recipeModal"
                                                data-recipe-id="<?= (int)$r['id'] ?>"
                                                data-title="<?= htmlspecialchars($r['title'], ENT_QUOTES) ?>"
                                                data-category="<?= htmlspecialchars($r['category'], ENT_QUOTES) ?>"
                                                data-time="<?= htmlspecialchars($r['prep_time'], ENT_QUOTES) ?> min"
                                                data-difficulty="<?= htmlspecialchars($r['difficulty'], ENT_QUOTES) ?>"
                                                data-image="<?= htmlspecialchars($r['image_url'], ENT_QUOTES) ?>"
                                                data-ingredients="<?= htmlspecialchars($r['ingredients'], ENT_QUOTES) ?>"
                                                data-instructions="<?= htmlspecialchars($r['instructions'], ENT_QUOTES) ?>"
                                                onclick="openRecipeModal(this)">
                                                View Recipe
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-journal-x fs-1 text-muted"></i>
                            <p class="text-muted mt-2">No recipes found in database.</p>
                        </div>
                    <?php endif; ?>

                </div>

            </section>

        </div>
    </main>

    <!-- Inject MySQL Recipes directly into window.dbRecipes for instant JS lookup -->
    <script>
        window.dbRecipes = window.dbRecipes || {};
        <?php foreach ($recipes as $r): ?>
            window.dbRecipes[<?= (int)$r['id'] ?>] = <?= json_encode([
                'id'           => (int)$r['id'],
                'title'        => $r['title'],
                'category'     => $r['category'],
                'time'         => $r['prep_time'] . ' mins',
                'difficulty'   => $r['difficulty'],
                'image'        => $r['image_url'] ?: 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?auto=format&fit=crop&w=800&q=80',
                'ingredients'  => array_values(array_filter(array_map('trim', explode("\n", $r['ingredients'])))),
                'instructions' => array_values(array_filter(array_map('trim', explode("\n", $r['instructions']))))
            ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
        <?php endforeach; ?>
    </script>

    <!-- Add Recipe Modal (CRUD Engine Module for Authenticated Users) -->
    <?php if (is_logged_in()): ?>
    <div class="modal fade" id="addRecipeModal" tabindex="-1" aria-labelledby="addRecipeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold" id="addRecipeModalLabel"><i class="bi bi-plus-circle me-2"></i>Add New Recipe (MySQL CRUD Module)</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="add_recipe.php" method="POST">
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-semibold small">Recipe Title</label>
                                <input type="text" name="title" class="form-control" placeholder="e.g. Creamy Mushroom Pasta" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold small">Category</label>
                                <select name="category" class="form-select" required>
                                    <option value="Breakfast">Breakfast</option>
                                    <option value="Lunch">Lunch</option>
                                    <option value="Dinner" selected>Dinner</option>
                                    <option value="Dessert">Dessert</option>
                                    <option value="Seafood">Seafood</option>
                                    <option value="Vegan">Vegan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Cooking Time (minutes)</label>
                                <input type="number" name="prep_time" class="form-control" placeholder="e.g. 30" min="5" max="300" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Difficulty Level</label>
                                <select name="difficulty" class="form-select" required>
                                    <option value="Easy">Easy</option>
                                    <option value="Medium" selected>Medium</option>
                                    <option value="Hard">Hard</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold small">Image URL (Optional)</label>
                                <input type="url" name="image_url" class="form-control" placeholder="https://images.unsplash.com/...">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold small">Ingredients (One per line)</label>
                                <textarea name="ingredients" class="form-control" rows="3" placeholder="2 cups Flour&#10;1 tsp Salt&#10;1 cup Water" required></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold small">Cooking Instructions (Step-by-step)</label>
                                <textarea name="instructions" class="form-control" rows="4" placeholder="1. Mix ingredients in a bowl...&#10;2. Bake at 180°C for 25 minutes..." required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger fw-bold">Save Recipe to MySQL</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

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
                    <form id="newsletter-form-dash">
                        <input type="email" class="form-control newsletter-input" placeholder="[ Email Input ]" required>
                        <button type="submit" class="btn btn-subscribe">[ Subscribe ]</button>
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
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="js/main.js"></script>
    <script src="js/filter.js"></script>
</body>
</html>
