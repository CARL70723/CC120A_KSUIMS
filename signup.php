<?php
$mysqli = new mysqli("localhost", "root", "", "masubay/magaway_parking_reservations");

$fname = isset($_POST['fname']) ? $_POST['fname'] : null;
$lname = isset($_POST['lname']) ? $_POST['lname'] : null;
$mname = isset($_POST['mname']) ? $_POST['mname'] : null;
$carModel = isset($_POST['car_model']) ? $_POST['car_model'] : null;
$color = isset($_POST['color']) ? $_POST['color'] : null;
$licensePlate = isset($_POST['license_plate']) ? $_POST['license_plate'] : null;
$contact = isset($_POST['contact']) ? $_POST['contact'] : null;
$sex = isset($_POST['sex']) ? $_POST['sex'] : null;

if (empty($fname) || empty($lname) || empty($carModel) || empty($color) || empty($licensePlate) || empty($contact) || empty($sex)) {
    echo "All fields are required.";
} else {
    $query = "INSERT INTO users (fname, lname, mname, car_model, color, license_plate, contact, sex) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        echo "Error: " . $mysqli->error;
    } else {
        $stmt->bind_param("ssssssss", $fname, $lname, $mname, $carModel, $color, $licensePlate, $contact, $sex);

        if ($stmt->execute()) {
            header("Location: reservation_form.html");
            exit();
        } else {
            echo "Error: Unable to process your sign-up. Please try again later.";
            error_log("SQL Error: " . $stmt->error);
        }

        $stmt->close();
    }
}
$mysqli->close();
?>

