<?php 
    define("CAR_DB", $_SERVER['DOCUMENT_ROOT'] . '/assets/data/cars.json');

    $data = null;
    $cars;
    $last_id;

    if (file_exists(CAR_DB)) {
        $data = json_decode(file_get_contents(CAR_DB), true);
        $cars = $data['cars'] ?? [];
    } else {
        $cars = [];
        $last_id = 0;
    }

    $grid_index = 1;

    if ($cars) {
        foreach ($cars as $car) {
            echo '
            <a href="/car.php?id=' . $car['id'] . '">
                <div class="grid-item ' . 'item-' . $grid_index .'">
                    <div class="car-card">
                        <div class="car-thumbnail">
                            <div class="car-image-container"><img src="' . htmlspecialchars($car['thumbnail']) . '" alt="' . htmlspecialchars($car['model']) . ' ' . htmlspecialchars($car['model']) . '"></div>
                            <div class="price-tag">' . number_format($car['daily_price_huf'], 0, ',', ' ') . ' Ft / Nap</div>
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
    }
?>