<?php
header('Content-Type: application/json');
define('CAR_DB', $_SERVER['DOCUMENT_ROOT'] . '/assets/data/cars.json');

$requestPayload = file_get_contents("php://input");
$data = json_decode($requestPayload, true);

if (!isset($data['carId'])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid request"]);
    exit;
}

$carId = $data['carId'];

if (file_exists(CAR_DB)) {
    $data_cars = json_decode(file_get_contents(CAR_DB), true);
    $cars = $data_cars['cars'] ?? [];
    $last_id = $data_cars['last_id'] ?? 0;
} else {
    $cars = [];
    $last_id = 0;
}

$updated_cars = array_filter($cars, function ($car) use ($carId) {
    return $car['id'] != $carId;
});

$updated_cars = array_values($updated_cars);

if ($carId == $last_id) {
    $new_last_id = 0;
    foreach ($updated_cars as $car) {
        if ($car['id'] > $new_last_id) {
            $new_last_id = $car['id'];
        }
    }
    $last_id = $new_last_id;
}

$result = file_put_contents(CAR_DB, json_encode(['cars' => $updated_cars, 'last_id' => $last_id], JSON_PRETTY_PRINT));

if ($result === false) {
    http_response_code(500);
    echo json_encode(["error" => "Hiba az autó törlése során"]);
    exit;
}

http_response_code(200);
echo json_encode(["message" => "Autó sikeresen törölve"]);
?>
