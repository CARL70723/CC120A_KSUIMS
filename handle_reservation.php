<?php
$mysqli = new mysqli("localhost", "root", "", "masubay/magaway_parking_reservations");

$name = isset($_POST['name']) ? $_POST['name'] : null;
$carModel = isset($_POST['car_model']) ? $_POST['car_model'] : null;
$licensePlate = isset($_POST['license_plate']) ? $_POST['license_plate'] : null;
$cellphoneNo = isset($_POST['cellphone_no']) ? $_POST['cellphone_no'] : null; 
$reservationDate = isset($_POST['reservation_date']) ? $_POST['reservation_date'] : null;
$reservationType = isset($_POST['reservation_type']) ? $_POST['reservation_type'] : null;
$duration = isset($_POST['duration']) ? $_POST['duration'] : null;

if (empty($name) || empty($carModel) || empty($licensePlate) || empty($cellphoneNo) || empty($reservationDate) || empty($reservationType) || empty($duration)) {
    echo "All fields are required.";
} else {
    $table = ($reservationType === 'valet') ? 'valet_r' : 'regular_r';

    $query = "INSERT INTO $table (name, car_model, license_plate, cellphone_no, reservation_date, duration_minutes, reserved) VALUES (?, ?, ?, ?, ?, ?, 1)";
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        echo "Error: " . $mysqli->error;
    } else {
        $stmt->bind_param("sssssi", $name, $carModel, $licensePlate, $cellphoneNo, $reservationDate, $duration);

        if ($stmt->execute()) {
            header("Location:greet.htm");
            exit();
        } else {
            echo "Error: Unable to process your reservation. Please try again later.";
            error_log("SQL Error: " . $stmt->error);
        }
        $stmt->close();
    }
}

$mysqli->close();
?>
