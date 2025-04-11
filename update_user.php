<?php
$mysqli = new mysqli("localhost", "root", "", "masubay/magaway_parking_reservations");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have sanitized user input for security
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $fname = isset($_POST['fname']) ? $_POST['fname'] : null;
    $lname = isset($_POST['lname']) ? $_POST['lname'] : null;
    $mname = isset($_POST['mname']) ? $_POST['mname'] : null;
    $carModel = isset($_POST['car_model']) ? $_POST['car_model'] : null;
    $color = isset($_POST['color']) ? $_POST['color'] : null;
    $licensePlate = isset($_POST['license_plate']) ? $_POST['license_plate'] : null;
    $contact = isset($_POST['contact']) ? $_POST['contact'] : null;
    $sex = isset($_POST['sex']) ? $_POST['sex'] : null;

    // Update user information in the database using prepared statements
    $query = "UPDATE users SET 
                fname = ?,
                lname = ?,
                mname = ?,
                car_model = ?,
                color = ?,
                license_plate = ?,
                contact = ?,
                sex = ?
              WHERE id = ?";
    $stmt = $mysqli->prepare($query);

    // Bind parameters
$stmt->bind_param("ssssssssi", $fname, $lname, $mname, $carModel, $color, $licensePlate, $contact, $sex, $id);

    // Execute the statement
    $stmt->execute();

    // Check for success
    if ($stmt->affected_rows > 0) {
        echo "User information updated successfully.";
    } else {
        echo "Error updating user information: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Invalid request.";
}

// Close the connection
$mysqli->close();
?>
