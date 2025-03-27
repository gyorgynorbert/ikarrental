<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?php 
        switch ($pageTitle) {
            case 'Kezdőlap | iKarRental': 
                echo '<link rel="stylesheet" href="/assets/css/main_index.css">';
                break;
            case 'Profil | iKarRental':
                echo '<link rel="stylesheet" href="/assets/css/user_profile.css">';
                break;
            case 'Admin | iKarRental':
                echo '<link rel="stylesheet" href="/assets/css/admin_profile.css">';
            default:
                echo '<link rel="stylesheet" href="/assets/css/main_car.css">';
                break;
        }
    ?>
    <title><?php echo $pageTitle ?? 'iKarRental'; ?></title>
    <script defer src="/assets/js/auth.js"></script>
    <script defer src="/assets/js/load_filters.js"></script>
</head>
<body>
    <nav>
        <div class="navbar-wrapper">
            <div class="navbar-logo-container"><a href="index.php" class="navbar-logo">iKarRental</a></div>
            
            <div class="hamburger">
                <div class="line1 ham-line"></div>
                <div class="line2 ham-line"></div>
                <div class="line3 ham-line"></div>
            </div>

            <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>

            <div class="navbar-profile-container">
                <div class="navbar-profile">
                    <div class="name"><?php echo $_SESSION['user']['name'] ?></div>
                    <div class="navbar-profile-image">
                        <img src="/assets/media/profile_picture.jpg" alt="Profile picture">
                    </div>
                </div>
                <div class="navbar-profile-dropdown">
                    <ul class="dropdown-options">
                        <li><a href="/profile.php" class="effect-underline"><i class="fa fa-user"></i>Profil</a></li>
                        <li><a href="/logout.php" class="red effect-underline"><i class="fa fa-sign-out"></i>Kijelentkezés</a></li>
                    </ul>
                </div>
            </div>    

            <?php else: ?>

            <div class="navbar-menu-container">
                <ul class="navbar-menu">
                    <li class="navbar-menu-item"><button id="openLoginBtn">Bejelentkezés</button></li>
                    <li class="navbar-menu-item"><button id="openRegisterBtn">Regisztráció</button></li>
                </ul>
            </div>

            <?php endif; ?>

        </div>

        <div id="loginModal" class="modal hidden">
            <div class="modal-content">
                <span class="close-modal" id="closeLoginModal">&times;</span>
                <form id="loginForm" action="login.php" method="POST" novalidate>
                    <label for="loginEmail">Email:</label>
                    <input type="email" id="loginEmail" name="email" required placeholder="Adja meg a emailjét">
                    <label for="loginPassword">Jelszó:</label>
                    <input type="password" id="loginPassword" name="password" required placeholder="Adja meg a jelszavát">
                    <button type="submit">Bejelentkezés</button>
                </form>
            </div>
        </div>

        <div id="registerModal" class="modal hidden">
            <div class="modal-content">
                <span class="close-modal" id="closeRegisterModal">&times;</span>
                <form id="registerForm" action="register.php" method="POST" novalidate>
                    <label for="registerUsername">Teljes neve:</label>
                    <input type="text" id="registerUsername" name="name" required placeholder="Adja meg a nevét">
                    <label for="registerEmail">Email:</label>
                    <input type="email" id="registerEmail" name="email" required placeholder="Adja meg az emailjét">
                    <label for="registerPassword">Jelszó:</label>
                    <input type="password" id="registerPassword" name="password" required placeholder="Adja meg a jelszavát">
                    <button type="submit">Regisztráció</button>
                </form>
            </div>
        </div>
        <div class="modal-overlay hidden" id="modalOverlay"></div>
    </nav>