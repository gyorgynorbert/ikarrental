<?php 
    $pageTitle = 'Profil | iKarRental';
    include $_SERVER['DOCUMENT_ROOT'] . '/assets/includes/navbar.php';
?>

    <main>
        <div class="main-wrapper">
            <div class="profile-grid-container">
                <div class="profile-grid">
                    <div class="profile-grid-left">
                        <div class="profile-picture-container"><img src="/assets/media/profile_picture.jpg" alt="Profile picture"></div>
                        <div class="profile-name-container"><h2>Szia <?php echo $_SESSION['user']['name'] ?>!</h2></div>
                    </div>
                    <div class="profile-grid-right">
                        <div class="profile-bookings-container">
                            <div class="profile-bookings-title">
                                <h2>Korábbi foglalásaid</h2>
                            </div>
                            <div class="bookings-grid-container">
                                <div class="profile-bookings-grid-container">
                                    <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/includes/fetch_bookings.php'?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>