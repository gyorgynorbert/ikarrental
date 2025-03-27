<?php 
    define("CAR_DB",$_SERVER['DOCUMENT_ROOT'] . '/assets/data/cars.json');
    if (file_exists(CAR_DB)) {
        $data = json_decode(file_get_contents(CAR_DB), true);
        $cars = $data['cars'] ?? [];
    } else {
        $cars = [];
        $last_id = 0;
    }

    $brands = [];
    $fuel_types = [];
    $passengers = []; 
    $years = [];
    $transmissions = [];

    foreach ($cars as $car) {
        $brands[] = $car['brand'];
        $fuel_types[] = $car['fuel_type'];
        $passengers[] = $car['passengers'];
        $years[] = $car['year'];
        $transmissions[] = $car['transmission'];
    }

    $brands = array_unique($brands);
    sort($brands);

    $fuel_types = array_unique($fuel_types);
    sort($fuel_types);

    $passengers = array_unique($passengers);
    sort($passengers);

    $years = array_unique($years);
    sort($years);

    $transmissions = array_unique($transmissions);
    sort($transmissions);

    header('Content-Type: application/json');
    echo json_encode([
        'brands' => $brands,
        'fuel_types' => $fuel_types,
        'passengers' => $passengers,
        'years' => $years,
        'transmissions' => $transmissions
    ]);
?>