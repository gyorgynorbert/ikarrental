<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $email = $_SESSION['user']['email'];

    if (htmlspecialchars($email) === 'admin@ikarrental.com' && $_SESSION['logged_in']) {
        include $_SERVER['DOCUMENT_ROOT'] . '/assets/includes/admin_page.php';
    } else {
        include $_SERVER['DOCUMENT_ROOT'] . '/assets/includes/user_page.php';
    }
?>