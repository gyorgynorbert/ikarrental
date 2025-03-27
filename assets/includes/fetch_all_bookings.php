<?php
    define("BOOKING_DB", $_SERVER['DOCUMENT_ROOT'] . '/assets/data/bookings.json');

    $data_cars = null;
    $data_bookings = null;
    $cars = null;
    $bookings = null;

    if (file_exists(CAR_DB)) {
        $data_cars = json_decode(file_get_contents(CAR_DB), true);
        $cars = $data_cars['cars'] ?? [];
    } else {
        $cars = [];
    }

    if (file_exists(filename: BOOKING_DB)) {
        $data_bookings = json_decode(file_get_contents(BOOKING_DB), true);
        $bookings = $data_bookings['bookings'] ?? [];
    } else {
        $bookings = [];
    }

    $user_id = null;
    $grid_index = 1;

    if ($_SESSION['logged_in'] === true) {
        $user_id = $_SESSION['user']['email'];
    }

    if ($bookings) {
        foreach ($bookings as $booking) {
            $car_id = $booking['car_id'];
            $car = null;

            foreach($cars as $car_entry) {
                if ($car_entry['id'] === $car_id) {
                    $car = $car_entry;
                    break;
                }
            }
            echo '
                <a href="/car.php?id='. htmlspecialchars($car_id) .'">
                    <div class="grid-item' . ' item-' . $grid_index .'">
                        <div class="booking-card">
                            <div class="car-thumbnail">
                                <div class="car-image-container"><img src="' . htmlspecialchars($car['thumbnail']) . '" alt="' . htmlspecialchars($car['model']) . ' ' . htmlspecialchars($car['model']) . '"></div>
                                <div class="car-delete-container"><button id="deleteBookingBtn" data-booking-id="' . htmlspecialchars($booking['id']) .'">Törlés</button></div>
                            </div>
                            <div class="car-info">
                                <h3 class="car-title">' . htmlspecialchars($car['brand'] . ' ' . $car['model']) . '</h3>
                                <div class="car-details">
                                    <span class="chip">' . htmlspecialchars($booking['user']) . ' </span>
                                    <span class="chip">' . htmlspecialchars($booking['from']) . '-tól</span>
                                    <span class="chip">' . htmlspecialchars($booking['to']) . '-ig</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                ';
            $grid_index++;
        }
    } else {
        echo '
            <h2>Még nincs foglalás!</h2>
        ';
    }
?>