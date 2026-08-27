<?php


require_once '../includes/db.php';
require_once '../includes/functions.php';

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize_input($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email)) {
        $errors[] = "Email address is required.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($errors)) {
        // Prepare SQL statement to fetch user record by email
        $stmt = $pdo->prepare("SELECT id, username, email, password FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        // Verify password using password_verify()
        if ($user && password_verify($password, $user['password'])) {
            
            // Regenerate session ID for security as required by course guide
            session_regenerate_id(true);

            // Store user session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['success_msg'] = "Welcome back, " . htmlspecialchars($user['username']) . "!";

            header("Location: ../dashboard.php");
            exit();
        } else {
            $errors[] = "Invalid email address or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlavorForge - Login</title>
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
            <div class="col-md-5 col-lg-4">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="bg-danger text-white text-center py-4">
                        <i class="bi bi-person-lock fs-1"></i>
                        <h4 class="fw-bold mb-0">Welcome Back</h4>
                        <p class="small text-white-50 mb-0">Sign in to your FlavorForge account</p>
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

                        <form action="login.php" method="POST" id="loginForm" novalidate>
                            <div class="mb-3">
                                <label for="loginEmail" class="form-label small fw-semibold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                                    <input type="email" name="email" id="loginEmail" class="form-control border-start-0 bg-light" value="<?= htmlspecialchars($email) ?>" placeholder="user@example.com" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="loginPassword" class="form-label small fw-semibold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                                    <input type="password" name="password" id="loginPassword" class="form-control border-start-0 bg-light" placeholder="••••••••" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-danger w-100 py-2 fw-bold rounded-3 shadow-sm mb-3">
                                Login
                            </button>
                        </form>

                        <div class="text-center small text-muted">
                            Don't have an account? <a href="register.php" class="text-danger fw-bold text-decoration-none">Register here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
