<?php
$mysqli = new mysqli("localhost", "root", "", "masubay/magaway_parking_reservations");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get values from the form
    $id = isset($_POST['id']) ? $_POST['id'] : null; // Assuming you have an input with name 'id' in your form
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $carModel = isset($_POST['car_model']) ? $_POST['car_model'] : null;
    $licensePlate = isset($_POST['license_plate']) ? $_POST['license_plate'] : null;
    $cellphoneNo = isset($_POST['cellphone_no']) ? $_POST['cellphone_no'] : null; 
    $reservationDate = isset($_POST['reservation_date']) ? $_POST['reservation_date'] : null;
    $reservationType = isset($_POST['reservation_type']) ? $_POST['reservation_type'] : null;
    $duration = isset($_POST['duration']) ? $_POST['duration'] : null;
    
    // Update valet reservation in the database
    $query = "UPDATE valet_reservations SET name = ?, car_model = ?, license_plate = ?, cellphone_no = ?, reservation_date = ?, reservation_type = ?, duration = ? WHERE id = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("sssssssi", $name, $carModel, $licensePlate, $cellphoneNo, $reservationDate, $reservationType, $duration, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Valet reservation updated successfully.";
        } else {
            echo "No changes made to the valet reservation.";
        }

        $stmt->close();
    } else {
        echo "Error in preparing the valet reservation update query: " . $mysqli->error;
    }
} else {
    echo "Invalid request. Please submit the form.";
}

// Close the database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Valet Reservation</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form action="update_valet_reservation.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="car_model">Car Model:</label>
        <input type="text" id="car_model" name="car_model" required>

        <label for="license_plate">License Plate:</label>
        <input type="text" id="license_plate" name="license_plate" required>

        <label for="cellphone_no">Cellphone No:</label>
        <input type="text" id="cellphone_no" name="cellphone_no" required>

        <label for="reservation_date">Reservation Date:</label>
        <input type="text" id="reservation_date" name="reservation_date" required>

        <label for="reservation_type">Reservation Type:</label>
        <input type="text" id="reservation_type" name="reservation_type" required>

        <label for="duration">Duration:</label>
        <input type="text" id="duration" name="duration" required>

        <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">

        <button type="submit">Update Valet Reservation</button>
    </form>
</body>
</html>
