<?php


require_once '../includes/db.php';
require_once '../includes/functions.php';

$errors = [];
$username = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize_input($_POST['username'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validation checks
    if (empty($username) || strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters long.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please provide a valid email address.";
    }

    if (empty($password) || strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Check if username or email already exists in database
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
        $stmt->execute([':username' => $username, ':email' => $email]);
        if ($stmt->fetch()) {
            $errors[] = "Username or Email address is already registered.";
        }
    }

    // Insert user into MySQL database using prepared statement
    if (empty($errors)) {
        // Hash password using modern PASSWORD_BCRYPT algorithm as required by course guide
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $insert_stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $success = $insert_stmt->execute([
            ':username' => $username,
            ':email'    => $email,
            ':password' => $hashed_password
        ]);

        if ($success) {
            $_SESSION['success_msg'] = "Registration successful! You can now log in.";
            header("Location: login.php");
            exit();
        } else {
            $errors[] = "Database error occurred while registering user.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlavorForge - Register Account</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bg-light">

    <!-- Header -->
    <header class="py-3 bg-white border-bottom shadow-sm">
        <div class="container text-center">
            <a class="navbar-brand fs-3 fw-bold text-dark text-decoration-none" href="../index.php">
                <i class="bi bi-journal-richtext text-danger me-2"></i>FlavorForge
            </a>
        </div>
    </header>

    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="bg-dark text-white text-center py-4">
                        <i class="bi bi-person-plus-fill fs-1 text-danger"></i>
                        <h4 class="fw-bold mb-0">Create Account</h4>
                        <p class="small text-white-50 mb-0">Join FlavorForge digital recipe community</p>
                    </div>
                    <div class="card-body p-4">
                        
                        <?php display_alerts(); ?>

                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger shadow-sm">
                                <ul class="mb-0 ps-3">
                                    <?php foreach ($errors as $err): ?>
                                        <li><?= htmlspecialchars($err) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="register.php" method="POST" id="registerForm" novalidate>
                            <div class="mb-3">
                                <label for="regUsername" class="form-label small fw-semibold">Username</label>
                                <input type="text" name="username" id="regUsername" class="form-control bg-light" value="<?= htmlspecialchars($username) ?>" placeholder="e.g. chef_sithumi" required>
                            </div>
                            <div class="mb-3">
                                <label for="regEmail" class="form-label small fw-semibold">Email Address</label>
                                <input type="email" name="email" id="regEmail" class="form-control bg-light" value="<?= htmlspecialchars($email) ?>" placeholder="user@example.com" required>
                            </div>
                            <div class="mb-3">
                                <label for="regPassword" class="form-label small fw-semibold">Password</label>
                                <input type="password" name="password" id="regPassword" class="form-control bg-light" placeholder="At least 6 characters" required>
                            </div>
                            <div class="mb-4">
                                <label for="regConfirmPassword" class="form-label small fw-semibold">Confirm Password</label>
                                <input type="password" name="confirm_password" id="regConfirmPassword" class="form-control bg-light" placeholder="Re-enter password" required>
                            </div>
                            <button type="submit" class="btn btn-danger w-100 py-2 fw-bold rounded-3 shadow-sm mb-3">
                                Create Account
                            </button>
                        </form>

                        <div class="text-center small text-muted">
                            Already have an account? <a href="login.php" class="text-danger fw-bold text-decoration-none">Login here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>