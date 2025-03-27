
<?php
    header('Content-Type: text/html; charset=utf-8');
    define('CAR_DB', $_SERVER['DOCUMENT_ROOT'] . '/assets/data/cars.json');

    if (file_exists(CAR_DB)) {
        $data = json_decode(file_get_contents(CAR_DB), true);
        $cars = $data['cars'] ?? [];
    } else {
        $cars = [];
        $last_id = 0;
    }

    $brand = isset($_GET['brand']) ? $_GET['brand'] : '';
    $fuel_type = isset($_GET['fuel_type']) ? $_GET['fuel_type'] : '';
    $passengers = isset($_GET['passengers']) ? $_GET['passengers'] : '';
    $year = isset($_GET['year']) ? $_GET['year'] : '';
    $transmission = isset($_GET['transmission']) ? $_GET['transmission'] : '';
    $price_to = isset($_GET['price-to']) && $_GET['price-to'] !== '' ? (int)$_GET['price-to'] * 1000 : null;
    $price_from = isset($_GET['price-from']) && $_GET['price-from'] !== '' ? (int)$_GET['price-from'] * 1000 : null;


    $filtered_cars = array_filter($cars, function ($car) use ($brand, $fuel_type, $passengers, $year, $transmission, $price_to, $price_from) {
        if ($brand && strcasecmp($car['brand'], $brand) !== 0) return false;
        if ($fuel_type && strcasecmp($car['fuel_type'], $fuel_type) !== 0) return false;
        if ($passengers && $car['passengers'] != $passengers) return false;
        if ($year && $car['year'] != $year) return false;
        if ($transmission && $car['transmission'] !== $transmission) return false;
        if ($price_to !== null && $car['daily_price_huf'] > $price_to) return false;
        if ($price_from !== null && $car['daily_price_huf'] < $price_from) return false;

        return true;
    });

    foreach ($filtered_cars as $car) {
        $grid_index = 1;
        echo '
        <a href="' . '/car.php?id=' . $car['id'] . '">
            <div class="grid-item ' . 'item-' . $grid_index .'">
                <div class="car-card">
                    <div class="car-thumbnail">
                        <div class="car-image-container"><img src="' . htmlspecialchars($car['thumbnail']) . '" alt="' . htmlspecialchars($car['model']) . ' ' . htmlspecialchars($car['model']) . '"></div>
                        <div class="price-tag">' . number_format($car['daily_price_huf'], 0, '.', ',') . ' HUF / Nap</div>
                    </div>
                    <div class="car-info">
                        <h3 class="car-title">' . htmlspecialchars($car['brand'] . ' ' . $car['model']) . '</h3>
                        <div class="car-details">
                            <span class="chip">' . htmlspecialchars($car['passengers']) . ' Férőhely</span>
                            <span class="chip">' . htmlspecialchars($car['fuel_type']) . '</span>
                            <span class="chip">' . htmlspecialchars($car['year']) . '</span>
                            <span class="chip">' . htmlspecialchars($car['transmission']) . '</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>';
        $grid_index++;
    }
?>