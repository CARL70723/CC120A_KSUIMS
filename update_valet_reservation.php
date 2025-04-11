<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Valet Reservation</title>
    <style>
        body {
            font-family: 'Calibri', sans-serif;
            background-color: rgb(149, 243, 238);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        h2 {
            color: #007BFF;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #007BFF;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #007BFF;
            border-radius: 5px;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        footer {
            margin-top: 20px;
            font-size: 1.2em;
            color: #007BFF;
        }
    </style>
</head>
<body>
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
                ?>
                <form action="update_valet_reservation.php" method="post">
                    <h2>Edit Valet Reservation</h2>

                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?= $row['name'] ?>" required>

                    <label for="car_model">Car Model:</label>
                    <input type="text" id="car_model" name="car_model" value="<?= $row['car_model'] ?>" required>

                    <label for="license_plate">License Plate:</label>
                    <input type="text" id="license_plate" name="license_plate" value="<?= $row['license_plate'] ?>" required>

                    <label for="cellphone_no">Cellphone No.:</label>
                    <input type="tel" id="cellphone_no" name="cellphone_no" value="<?= $row['cellphone_no'] ?>" required>

                    <label for="reservation_date">Reservation Date:</label>
                    <input type="text" id="reservation_date" name="reservation_date" value="<?= $row['reservation_date'] ?>" readonly required>

                    <label for="duration">Parking Duration (in minutes):</label>
                    <input type="number" id="duration" name="duration" value="<?= $row['duration'] ?>" required>

                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input type="submit" value="Update Reservation">
                </form>
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

    <footer>
        <p>Masubay/Magaway 5⭐ Hotel Valet Parking Services. All rights reserved.</p>
        <p>MANAGER DASHBOARD</p>
    </footer>
</body>
</html>
