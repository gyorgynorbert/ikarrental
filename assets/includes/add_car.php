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
    $last_id = null;

    if (file_exists(CAR_DB)) {
        $data_cars = json_decode(file_get_contents(CAR_DB), true);
        $cars = $data_cars['cars'] ?? [];
        $last_id = $data_cars['last_id'] ?? 0;
    } else {
        $cars = [];
        $last_id = 0;
    }

    $car_brand = sanitize($_POST['carBrand']);
    $car_model = sanitize($_POST['carModel']);
    $car_trans = sanitize($_POST['carTransmission']);
    $car_year  = sanitize($_POST['carYear']);
    $car_fuel  = sanitize($_POST['carFuel']);
    $car_passengers = sanitize($_POST['carPassengers']);
    $car_price = sanitize($_POST['carPrice']);
    $car_thumbnail = sanitize($_POST['carThumbnail']);

    $new_id = $last_id + 1;

    $new_car = [
        'id' => (string)$new_id,
        'brand' => $car_brand,
        'model' => $car_model,
        'transmission' => $car_trans,
        'year' => $car_year,
        'fuel_type' => $car_fuel,
        'passengers' => $car_passengers,
        'daily_price_huf' => $car_price,
        'thumbnail' => $car_thumbnail
    ];

    $cars[] = $new_car;
    $data = [
        'cars' => $cars,
        'last_id' => $new_id
    ];

    if (file_put_contents(CAR_DB, json_encode($data, JSON_PRETTY_PRINT)) === false) {
        $response['errors']['server'] = "Nem sikerült a foglalást menteni. Próbáld újra később.";
        echo json_encode($response);
        exit;
    }

    $response['success'] = true;
    $response['message'] = 'Sikeresen hozzáadtad az autót a flottához!';
    echo json_encode($response);
    exit;

?>