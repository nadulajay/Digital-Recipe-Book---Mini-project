<?php


require_once 'includes/db.php';
require_once 'includes/functions.php';

// Ensure user is logged in before allowing recipe submission
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize_input($_POST['title'] ?? '');
    $category = sanitize_input($_POST['category'] ?? '');
    $prep_time = intval($_POST['prep_time'] ?? 0);
    $difficulty = sanitize_input($_POST['difficulty'] ?? 'Easy');
    $ingredients = sanitize_input($_POST['ingredients'] ?? '');
    $instructions = sanitize_input($_POST['instructions'] ?? '');
    $image_url = sanitize_input($_POST['image_url'] ?? '');

    // Default local image if none provided
    if (empty($image_url)) {
        $image_url = 'pictures/photo-1498837167922-ddd27525d352.avif';
    }

    $errors = [];

    if (empty($title)) $errors[] = "Recipe title is required.";
    if (empty($category)) $errors[] = "Category is required.";
    if ($prep_time <= 0) $errors[] = "Cooking time must be greater than 0 minutes.";
    if (empty($ingredients)) $errors[] = "Ingredients list cannot be empty.";
    if (empty($instructions)) $errors[] = "Instructions cannot be empty.";

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO recipes (title, category, prep_time, difficulty, ingredients, instructions, image_url, user_id) VALUES (:title, :category, :prep_time, :difficulty, :ingredients, :instructions, :image_url, :user_id)");
        
        $result = $stmt->execute([
            ':title'        => $title,
            ':category'     => $category,
            ':prep_time'    => $prep_time,
            ':difficulty'   => $difficulty,
            ':ingredients'  => $ingredients,
            ':instructions' => $instructions,
            ':image_url'    => $image_url,
            ':user_id'      => $_SESSION['user_id']
        ]);

        if ($result) {
            $_SESSION['success_msg'] = "Recipe '$title' added to database successfully!";
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['error_msg'] = "Failed to add recipe to database.";
            header("Location: dashboard.php");
            exit();
        }
    } else {
        $_SESSION['error_msg'] = implode(" ", $errors);
        header("Location: dashboard.php");
        exit();
    }
}
?>