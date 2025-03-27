<?php
    function sanitize($input) {
        $input = trim($input);
        $input = strip_tags($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    header('Content-Type: application/json');
    define('CAR_DB', $_SERVER['DOCUMENT_ROOT'] . '/assets/data/cars.json');

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $response = [
        'success' => false,
        'errors' => []
    ];

    $data_cars = null;
    $cars = null;

    if (file_exists(CAR_DB)) {
        $data_cars = json_decode(file_get_contents(CAR_DB), true);
        $cars = $data_cars['cars'] ?? [];
    } else {
        $cars = [];
    }

    $car_id = sanitize($_POST['carId']);
    $car_brand = sanitize($_POST['carBrand']);
    $car_model = sanitize($_POST['carModel']);
    $car_trans = sanitize($_POST['carTransmission']);
    $car_year  = sanitize($_POST['carYear']);
    $car_fuel  = sanitize($_POST['carFuel']);
    $car_passengers = sanitize($_POST['carPassengers']);
    $car_price = sanitize($_POST['carPrice']);
    $car_thumbnail = sanitize($_POST['carThumbnail']);

    $car_found = false;
    foreach($cars as &$car) {
        if ($car['id'] == $car_id) {
            $car['brand'] = $car_brand;
            $car['model'] = $car_model;
            $car['transmission'] = $car_trans;
            $car['year'] = $car_year;
            $car['fuel_type'] = $car_fuel;
            $car['passengers'] = $car_passengers;
            $car['daily_price_huf'] = $car_price;
            $car['thumbnail'] = $car_thumbnail;
            $car_found = true;
            break;
        }
    }

    if (!$car_found) {
        $response['errors'] = "Car not found.";
        echo json_encode($response);
        exit;
    }

    $data_cars['cars'] = $cars;

    if (file_put_contents(CAR_DB, json_encode($data_cars, JSON_PRETTY_PRINT))) {
        $response['success'] = true;
        $response['message'] = "Car successfully updated!";
    } else {
        $response['errors'] = "Failed to save changes.";
    }

    echo json_encode($response);
    exit;

?>