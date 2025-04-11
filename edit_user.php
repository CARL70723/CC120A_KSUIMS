<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: rgb(149, 243, 238);
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            margin-top: 10px;
        }

        input {
            margin-top: 5px;
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            margin-top: 10px;
            padding: 8px;
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
    <div class="container">
        <h2>Edit User</h2>
        <?php
            // Assuming you have received the user ID through $_GET['id']
            $userId = $_GET['id'];

            // Fetch user data based on the ID from the database using prepared statements
            $mysqli = new mysqli("localhost", "root", "", "masubay/magaway_parking_reservations");

            // Check connection
            if ($mysqli->connect_error) {
                die("Connection failed: " . $mysqli->connect_error);
            }

            $query = "SELECT * FROM users WHERE id = ?";
            $stmt = $mysqli->prepare($query);

            // Bind the parameter
            $stmt->bind_param("i", $userId);

            // Execute the statement
            $stmt->execute();

            // Get the result
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $userData = $result->fetch_assoc();
        ?>
        <form action="update_user.php" method="POST">
        
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" required>

            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" required>

            <label for="mname">Middle Name:</label>
            <input type="text" id="mname" name="mname" required>

            <label for="car_model">Car Model:</label>
            <input type="text" id="car_model" name="car_model" required>

            <label for="color">Car Color:</label>
            <input type="text" id="color" name="color" required>

            <label for="license_plate">License Plate:</label>
            <input type="text" id="license_plate" name="license_plate" required>

            <label for="contact">Contact:</label>
            <input type="text" id="contact" name="contact" required>

            <label for="sex">Sex:</label>
            <select id="sex" name="sex" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            <button><a href="update_user.php">Update User</button>
        </form>
        <?php
            } else {
                echo "User not found.";
            }

            // Close the statement and connection
            $stmt->close();
            $mysqli->close();
        ?>
    </div>
</body>
</html>
