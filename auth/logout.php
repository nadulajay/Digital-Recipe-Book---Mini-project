<?php


require_once '../includes/functions.php';

// Unset all session variables
$_SESSION = array();

// If session cookie exists, destroy it
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy session
session_destroy();

// Start a fresh session to pass logout success message
session_start();
$_SESSION['success_msg'] = "You have been logged out successfully.";

header("Location: ../index.php");
exit();
?>