<?php
    define('CAR_DB', $_SERVER['DOCUMENT_ROOT'] . '/assets/data/cars.json');
    
    if (file_exists(CAR_DB)) {
        $data = json_decode(file_get_contents(filename: CAR_DB), true);
        $cars = $data['cars'] ?? [];
    } else {
        $cars = [];
        $last_id = 0;
    }


    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function retrieve_car($id, $cars) {
        foreach ($cars as $car) {
            if($car['id'] === $id) {
                return $car;
            }
        }
    }

    if (empty($_GET['id'])) {
        header('Location: index.php');
    } else {
        $car_id = test_input($_GET['id']);
    }

    $current_car = retrieve_car($car_id, $cars);

    $pageTitle = '' . htmlspecialchars($current_car['brand']) . ' ' . htmlspecialchars($current_car['model']) . ' | iKarRental';
    include 'assets/includes/navbar.php';    
?>
    <main class="car-main">
        <div class="car-wrapper">
            <div class="car-grid-container">
                <div class="car-left-side grid-item">
                    <div class="car-picture">
                        <img src="<?php echo $current_car['thumbnail']; ?>" alt="<?php echo htmlspecialchars($current_car['brand']) . ' ' . htmlspecialchars($current_car['model']) ?>">
                        <div class="car-title-chip"><h2><?php echo htmlspecialchars($current_car['brand']) . ' ' . htmlspecialchars($current_car['model']) ?></h2></div>
                    </div>
                </div>
                <div class="right-side-wrapper">
                    <div class="car-right-side grid-item">
                        <div class="car-details">
                            <p><strong>Évjárat:</strong> <?php echo htmlspecialchars($current_car['year']); ?></p>
                            <p><strong>Üzemanyag:</strong> <?php echo htmlspecialchars($current_car['fuel_type']); ?></p>
                            <p><strong>Utasok:</strong> <?php echo htmlspecialchars($current_car['passengers']); ?> ülés</p>
                            <p><strong>Ára:</strong> <?php echo number_format($current_car['daily_price_huf'], 0, ',', ' '); ?> Ft / nap</p>
                        </div>
                        <?php if (!isset($_SESSION['user'])) { ?>
                        
                        <?php } else if ($_SESSION['user']['email'] === 'admin@ikarrental.com') { ?>
                        <div class="admin-buttons-container">
                            <button id="modifyCarBtn">Módosítás</button>
                            <div id="modifyCarWrapper" class="hidden-wrapper">
                                <div id="modifyCarContainer">
                                    <span class="close-modal" id="closeModifyCar">&times;</span>
                                    <form id="modifyCarForm" action="" method="POST" novalidate>
                                        <input type="hidden" id="carId" name="carId" value="<?php echo htmlspecialchars($current_car['id']); ?>">
                                        <div class="group">
                                            <label for="carBrand">Márka:</label>
                                            <input type="text" id="carBrand" name="carBrand" required placeholder="Autó márkája" value="<?php echo htmlspecialchars($current_car['brand']); ?>">
                                        </div>
                                        <div class="group">
                                            <label for="carModel">Model:</label>
                                            <input type="text" id="carModel" name="carModel" required placeholder="Autó modelje" value="<?php echo htmlspecialchars($current_car['model']); ?>">
                                        </div>
                                        <div class="group">
                                            <label for="carTransmission">Váltótípus:</label>
                                            <input type="text" id="carTransmission" name="carTransmission" required placeholder="Váltó típusa" value="<?php echo htmlspecialchars($current_car['transmission']); ?>">
                                        </div>
                                        <div class="group">
                                            <label for="carYear">Évjárat:</label>
                                            <input type="text" id="carYear" name="carYear" required placeholder="Évjárat" value="<?php echo htmlspecialchars($current_car['year']); ?>">
                                        </div>
                                        <div class="group">
                                            <label for="carFuel">Üzemanyag:</label>
                                            <input type="text" id="carFuel" name="carFuel" required placeholder="Üzemanyag" value="<?php echo htmlspecialchars($current_car['fuel_type']); ?>">
                                        </div>
                                        <div class="group">
                                            <label for="carPassengers">Utasok száma:</label>
                                            <input type="text" id="carPassengers" name="carPassengers" required placeholder="Utasok száma" value="<?php echo htmlspecialchars($current_car['passengers']); ?>">
                                        </div>
                                        <div class="group">
                                            <label for="carPrice">Ára:</label>
                                            <input type="text" id="carPrice" name="carPrice" required placeholder="Ára" value="<?php echo htmlspecialchars($current_car['daily_price_huf']); ?>">
                                        </div>
                                        <div class="group">
                                            <label for="carThumbnail">Autó képe:</label>
                                            <input type="text" id="carThumbnail" name="carThumbnail" required placeholder="Link" value="<?php echo htmlspecialchars($current_car['thumbnail']); ?>">
                                        </div>
                                        <button type="submit">Módosítás</button>
                                    </form>
                                    <span id="feedback"></span>
                                </div>
                            </div>
                            <button id="deleteCarBtn" data-car-id="<?php echo htmlspecialchars($current_car['id']); ?>">Törlés</button>
                        </div>
                        <?php } else { ?>
                        <div class="form-container">
                            <form id="bookingForm" method="POST" action="/assets/includes/book.php">
                                <div class="form-group">
                                    <input type="date" id="fromDate" name="fromDate" required>
                                    <label for="fromDate">-tól</label>
                                </div>
                                <div class="form-group">
                                <input type="date" id="toDate" name="toDate" required>
                                <label for="toDate">-ig</label>
                                </div>
                                <input type="hidden" name="car_id" value="<?php echo $current_car['id']; ?>">
                                <button type="submit" class="button">Foglalás</button>
                            </form>
                            <span id="formError"></span>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="modalOverlayBook" class="hidden-book">
            <div id="responseModal">
                <div class="modal-content-book">
                    <div id="modalBody"></div>
                </div>
                <div class="modal-footer">
                    <button id="okBtn" class="hide-on-fail">Rendben!</button>
                    <button id="goToBtn" class="hide-on-fail">Foglalás megtekintése</button>
                    <button id="retryBtn" class="hide-on-success">Újra</button>
                </div>
            </div>
        </div>
        <div id="mainFeedbackWrapper" class="hidden-wrapper">
            <div id="mainFeedbackContainer">
                <div id="mainFeedbackTextContainer">
                    <span id="mainFeedbackText"></span>
                </div>
                <div id="mainFeedbackButtonContainer">
                    <button id="mainFeedbackButton">Rendben!</button>
                </div>
            </div>
        </div>
        <div id="deleteConfirmWrapper" class="hidden-wrapper">
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
    </main>
    <?php if (!isset($_SESSION['user'])) { ?>
    <?php } else if ($_SESSION['user']['email'] === 'admin@ikarrental.com') { ?>
    <script defer src="/assets/js/modify_car.js"></script>
    <script defer src="/assets/js/delete_car.js"></script>
    <?php } else { ?>
    <script defer src="/assets/js/book_car.js"></script>
    <?php } ?>
</body>
</html>