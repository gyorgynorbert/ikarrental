<?php
    header('Content-Type: application/json');
    define('BOOKING_DB', $_SERVER['DOCUMENT_ROOT'] . '/assets/data/bookings.json');

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
  
    $requestPayload = file_get_contents("php://input");
    $data = json_decode($requestPayload, true);

    if (!isset($data['bookingId'])) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid request"]);
        exit;
    }

    $bookingId = $data['bookingId'];

    if (file_exists(BOOKING_DB)) {
        $data_bookings = json_decode(file_get_contents(BOOKING_DB), true);
        $bookings = $data_bookings['bookings'] ?? [];
        $last_id = $data_bookings['last_id'] ?? 0;
    } else {
        $bookings = [];
        $last_id = 0;
    }

    $updated_bookings = array_filter($bookings, function ($booking) use ($bookingId) {
        return $booking['id'] != $bookingId;
    });

    $updated_bookings = array_values($updated_bookings);

    if ($bookingId == $last_id) {
        $new_last_id = 0;
        foreach ($updated_bookings as $booking) {
            if ($booking['id'] > $new_last_id) {
                $new_last_id = $booking['id'];
            }
        }
        $last_id = $new_last_id;
    }

    file_put_contents(BOOKING_DB, json_encode(['bookings' => $updated_bookings, 'last_id' => $last_id], JSON_PRETTY_PRINT));

    http_response_code(200);
    echo json_encode(["message" => "Foglalás sikeresen törölve!"]);
    
?>