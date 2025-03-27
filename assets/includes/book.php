<?php
    header('Content-Type: application/json');

    define('BOOKING_DB', $_SERVER['DOCUMENT_ROOT'] . '/assets/data/bookings.json');
    define('CAR_DB', $_SERVER['DOCUMENT_ROOT'] . '/assets/data/cars.json');

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $response = [
        'success' => false,
        'errors' => []
    ];

    if (!isset($_SESSION['user'])) {
        $response['errors']['user'] = "Be kell lenned jelentkezve, hogy foglalni tudj!";
        echo json_encode($response);
        exit;
    }

    $user = $_SESSION['user'];

    $from_date_simple = htmlspecialchars($_POST['fromDate'] ?? null);
    $to_date_simple = htmlspecialchars($_POST['toDate'] ?? null);
    $car_id = htmlspecialchars($_POST['car_id'] ?? null);

    if (!$from_date_simple || !$to_date_simple || !$car_id) {
        $response['errors']['form'] = "Minden mezőt ki kell tölteni!";
        echo json_encode($response);
        exit;
    }

    if ($from_date_simple >= $to_date_simple) {
        $response['errors']['form'] = "Baj van a dátumokkal";
        echo json_encode($response);
        exit;
    }

    if (file_exists(BOOKING_DB)) {
        $data_bookings = json_decode(file_get_contents(BOOKING_DB), true);
        $bookings = $data_bookings['bookings'] ?? [];
        $last_id = $data_bookings['last_id'] ?? 0;
    } else {
        $bookings = [];
        $last_id = 0;
    }

    foreach ($bookings as $booking) {
        if ($booking['car_id'] == $car_id) {
            $existing_from = strtotime($booking['from']);
            $existing_to = strtotime($booking['to']);
            $new_from = strtotime($from_date_simple);
            $new_to = strtotime($to_date_simple);

            if (
                ($new_from <= $existing_from && $new_to >= $existing_to) || 
                ($new_from <= $existing_to && $new_to >= $existing_from)
            ) {
                $response['errors']['conflict'] = "Ez az autó már le van foglalva erre az időszakra!";
                echo json_encode($response);
                exit;
            }
        }
    }

    $new_id = $last_id + 1;
    $new_booking = [
        'id' => $new_id,
        'user' => $user['email'],
        'car_id' => $car_id,
        'from' => $from_date_simple,
        'to' => $to_date_simple,
    ];

    $bookings[] = $new_booking;
    $data = [
        'bookings' => $bookings,
        'last_id' => $new_id,
    ];

    if (file_put_contents(BOOKING_DB, json_encode($data, JSON_PRETTY_PRINT)) === false) {
        $response['errors']['server'] = "Nem sikerült a foglalást menteni. Próbáld újra később.";
        echo json_encode($response);
        exit;
    }

    if (file_exists(CAR_DB)) {
        $data_cars = json_decode(file_get_contents(CAR_DB), true);
        $cars = $data_cars['cars'] ?? [];
    } else {
        $cars = [];
    }

    $chosen_car = null;
    foreach ($cars as $car) {
        if ($car['id'] == $car_id) {
            $chosen_car = $car;
            break;
        }
    }

    $from_date = new DateTime($_POST['fromDate']);
    $to_date = new DateTime($_POST['toDate']);
    $days_booked = $from_date->diff($to_date)->format("%a");
    $price_per_day = $chosen_car['daily_price_huf'] ?? 0;
    $total_price = $price_per_day * $days_booked;

    $response['success'] = true;
    $response['message'] = "Sikeres foglalás!";
    $response['details'] = [
        'from' => $from_date->format('Y-m-d'),
        'to' => $to_date->format('Y-m-d'),
        'price_per_day' => $price_per_day,
        'total_price' => $total_price
    ];

    echo json_encode($response);
    exit;

