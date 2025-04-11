<?php
// Include necessary database connection or configuration file
$mysqli = new mysqli("localhost", "root", "", "masubay/magaway_parking_reservations");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if ID is provided through GET request
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch valet reservation details based on the provided ID
    $query = "SELECT * FROM valet_r WHERE id = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            // Your HTML form with fields pre-filled with fetched data
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Edit Valet Reservation</title>
            </head>
            <body>
                <h2>Edit Valet Reservation</h2>
                <form action="update_valet_reservation.php" method="post">
                    <!-- Add your form fields here with values pre-filled from $row -->
                    <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required>

            <label for="car_model">Car Model:</label>
            <input type="text" id="car_model" name="car_model" placeholder="Enter your car model" required>

            <label for="license_plate">License Plate:</label>
            <input type="text" id="license_plate" name="license_plate" placeholder="Enter your license plate" required>

            <label for="cellphone_no">Cellphone No.:</label>
            <input type="tel" id="cellphone_no" name="cellphone_no" placeholder="Enter your cellphone number" required>

            <label for="reservation_date">Reservation Date:</label>
            <input type="text" id="reservation_date" name="reservation_date" value="<?= $row['reservation_date'] ?>" readonly required>

            <label for="duration">Parking Duration (in minutes):</label>
            <input type="number" id="duration" name="duration" placeholder="Enter parking duration" required>

                    <!-- Add other form fields similarly -->

                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input type="submit" value="Update Reservation">
                </form>
            </body>
            </html>
            <?php
        } else {
            echo "No valet reservation found with the provided ID.";
        }

        $stmt->close();
    } else {
        echo "Error in preparing the valet reservation query: " . $mysqli->error;
    }
} else {
    echo "No valet reservation ID provided.";
}

// Close the database connection
$mysqli->close();
?>
