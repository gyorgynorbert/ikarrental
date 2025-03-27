<?php 
    $pageTitle = 'Admin | iKarRental';
    include $_SERVER['DOCUMENT_ROOT'] . '/assets/includes/navbar.php';
?>

<main>
    <div class="main-wrapper">
        <div class="admin-main-container">
            <div class="admin-profile-container">
                <div class="admin-picture-container"><img src="/assets/media/profile_picture.jpg" alt="Profile picture"></div>
                <div class="adming-name-container"><h2>Szia <?php echo $_SESSION['user']['name'] ?>!</h2></div>
            </div>
            <div class="admin-cars-container">
                <div class="admin-cars-title">
                    <div class="admin-title-items-container">
                        <h2>Az összes elérhető autó</h2>
                        <button id="createCarBtn">Autó hozzáadása</button>
                    </div>
                    <div id="carModalWrapper" class="create-car-modal-wrapper hidden">
                        <div id="carModalContainer" class="car-modal-container">
                            <span class="close-modal" id="closeCarModal">&times;</span>
                            <form id="addCarForm" action="" method="POST" novalidate>
                                <div class="group">
                                    <label for="carBrand">Márka:</label>
                                    <input type="text" id="carBrand" name="carBrand" required placeholder="Autó márkája">
                                </div>
                                <div class="group">
                                    <label for="carModel">Model:</label>
                                    <input type="text" id="carModel" name="carModel" required placeholder="Autó modelje">
                                </div>
                                <div class="group">
                                    <label for="carTransmission">Váltótípus:</label>
                                    <input type="text" id="carTransmission" name="carTransmission" required placeholder="Váltó típusa">
                                </div>
                                <div class="group">
                                    <label for="carYear">Évjárat:</label>
                                    <input type="text" id="carYear" name="carYear" required placeholder="Évjárat">
                                </div>
                                <div class="group">
                                    <label for="carFuel">Üzemanyag:</label>
                                    <input type="text" id="carFuel" name="carFuel" required placeholder="Üzemanyag">
                                </div>
                                <div class="group">
                                    <label for="carPassengers">Utasok száma:</label>
                                    <input type="text" id="carPassengers" name="carPassengers" required placeholder="Utasok száma">
                                </div>
                                <div class="group">
                                    <label for="carPrice">Ára:</label>
                                    <input type="text" id="carPrice" name="carPrice" required placeholder="Ára">
                                </div>
                                <div class="group">
                                    <label for="carThumbnail">Autó képe:</label>
                                    <input type="text" id="carThumbnail" name="carThumbnail" required placeholder="Link">
                                </div>
                                <button type="submit">Hozzáadás</button>
                            </form>
                            <span id="feedback"></span>
                        </div>
                    </div>
                </div>
                <div class="admin-cars-grid-container">
                    <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/includes/generate_cars.php';?>
                </div>
            </div>
            <div class="admin-bookings-container">
                <div class="admin-bookings-title">
                    <div class="admin-title-items-container">
                        <h2>Az összes foglalás</h2>
                    </div>
                </div>
                <div class="admin-bookings-grid-container">
                    <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/includes/fetch_all_bookings.php';?>
                </div>
            </div>
        </div>
    </div>
    <div id="mainFeedbackWrapper" class="hidden">
        <div id="mainFeedbackContainer">
            <div id="mainFeedbackTextContainer">
                <span id="mainFeedbackText"></span>
            </div>
            <div id="mainFeedbackButtonContainer">
                <button id="mainFeedbackButton">Rendben!</button>
            </div>
        </div>
    </div>
    <div id="deleteConfirmWrapper" class="hidden">
        <div id="deleteConfirmContainer">
            <div id="deleteTextContainer">
                <p id="deleteText">Biztosan törlöd ezt a foglalást? A törlés permanens!</p>
            </div>
            <div id="deletBtnsContainer">
                <button id="cancelDeleteBtn">Mégsem</button>
                <button id="deleteBtn">Törlés</button>
            </div>
        </div>
    </div>
    <script defer src="/assets/js/add_car.js"></script>
    <script defer src="/assets/js/delete_bookings.js"></script>
</main>