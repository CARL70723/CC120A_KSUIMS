<?php
$mysqli = new mysqli("localhost", "root", "", "masubay/magaway_parking_reservations");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Query for valet_r
$queryValet = "SELECT * FROM valet_r";
$resultValet = $mysqli->query($queryValet);

// Query for regular_r
$queryRegular = "SELECT * FROM regular_r";
$resultRegular = $mysqli->query($queryRegular);

// Query for users
$queryUsers = "SELECT * FROM users";
$resultUsers = $mysqli->query($queryUsers);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
               body {
            font-family: 'times new roman';
            margin: 1px;
            padding-top: 1px;
            min-height: 100vh;
            background-image: url(bg12.jpg);
            background-size: cover;
            display: flex;
            justify-content: left;
            align-items: center;
        }

        .container {
            margin-top: 30px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
            max-width: 800px;
            width: 100%;
            margin-left: 50px; /* Adjusted margin to move it to the left */
            margin-bottom: 30px;
        }

        header {
            background-color: rgb(149, 243, 238);
            color: black; /* Set header text color to white */
            padding: 1px;
            border-radius: 10px 10px 0 0;
            margin-bottom: 35px; /* Added margin for spacing */
        }

        footer {
            background-color: rgb(149, 243, 238);
            color: black; 
            margin-top: 40px;
            text-align: center;
            text-decoration: underline;
            padding: 1px;
            position: relative;
            bottom: 0;
            width: 100%;
            border-radius: 0 0 10px 10px;
            font-size: 1.3em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 40px;
        }

        th, td {
            padding: 8px;
            border: 2px solid #007BFF;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #007BFF;
            color:black; 
            font-weight: bold;
            font-size: 2em;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        h2 {
            color: #007BFF;
            margin-bottom: 2px;            /*report reservation  */
            font-family: 'tahoma';
            font-size: 2.4em;
        }

        h1 {
            color: #007BFF;
            margin-top: 5px;
            margin-bottom: 35px;            /*Masubay/Magaway 5⭐ Hotel Valet Parking Services*/
            font-size: 2.5em;
        }
        h3 {
            color: #007BFF;
            margin-bottom: 2px;            /*report reservation  */
            font-family: 'Ink Free';
            font-size: 1.8em;
        }
        h4 {
            text-decoration: underline;
            color: #007BFF;
            margin-bottom: 2px;            /*report reservation  */
            font-family: 'tahoma';
            font-size: 2.4em;
        }
        h5 {
            text-decoration: underline;
            color: #007BFF;
            margin-bottom: 2px;            /*report reservation  */
            font-family: 'tahoma';
            font-size: 2.4em;
        }
    
        .dataTable th, .dataTable td {
            padding: 8px;
            border: 1px solid #007BFF;          /*table labels*/
            font-size: 1em;
        }

        .dataTable th {
            background-color: #007BFF;
            color: #fff;
            font-weight: bold;
        }

        .dataTable td {
            padding: 8px;
            background-color: #f2f2f2;
        }
        .print-btn {
        margin-top: 100px;
            margin-right: 190px;
            position:fixed ;
            top: 25%;
            right: 0px;
            display: inline-block;
            padding: 10px 25px;
            font-size: 1.5em;
            background-color:  #0099ff;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease-in-out;
        }

        .print-btn:hover {
            background-color: #69e630;
        }

        .exit-link {
            position: fixed;
            bottom: 70px;
            right: 0px;
            list-style: none;
            margin-bottom: 5px;
            margin-right: 175px;
            padding: 0;
        }

        .exit-link li {
            display: inline-block;
            margin-left: 10px;
        }

        .exit-link a {
            display: block;
            padding: 4px 35px;
            font-size: 2.3em;
            background-color: #0099ff;
            color:white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease-in-out;
        }
        .exit-link a:hover {
            background-color: #69e630;
        }

        @media print {
            .exit-link, .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="container">
    <header>
            <h1>Masubay/Magaway 5⭐ Hotel Valet Parking Services</h1>
            <h2>Admin / Manager Reports</h2>
        </header>

        <div class="dataTableContainer">
            <h4>ALL USERS</H4>
            <h3>Users Table</h3>
            <?php
            // Display users table
            if ($resultUsers) {
                if ($resultUsers->num_rows > 0) {
                    echo "<table class='dataTable'>";
                    $headerPrinted = false;

                    while ($row = $resultUsers->fetch_assoc()) {
                        if (!$headerPrinted) {
                            echo "<tr>";
                            foreach ($row as $columnName => $value) {
                                echo "<th>$columnName</th>";
                            }
                            echo "</tr>";
                            $headerPrinted = true;
                        }

                        echo "<tr>";
                        foreach ($row as $columnName => $value) {
                            echo "<td>$value</td>";
                        }
                        echo "</tr>";
                    }

                    echo "</table>";
                } else {
                    echo "No data found for users.";
                }
            } else {
                echo "Error in query for users: " . $mysqli->error;
            }
            ?>
        </div>

            <h5>ALL RESERVATIONS</h5>
        <div class="dataTableContainer">
            <h3>Valet Reservations Table</h3>
            <?php
            // Display valet reservations table
            if ($resultValet) {
                if ($resultValet->num_rows > 0) {
                    echo "<table class='dataTable'>";
                    $headerPrinted = false;

                    while ($row = $resultValet->fetch_assoc()) {
                        if (!$headerPrinted) {
                            echo "<tr>";
                            foreach ($row as $columnName => $value) {
                                echo "<th>$columnName</th>";
                            }
                            echo "</tr>";
                            $headerPrinted = true;
                        }

                        echo "<tr>";
                        foreach ($row as $columnName => $value) {
                            echo "<td>$value</td>";
                        }
                        echo "</tr>";
                    }

                    echo "</table>";
                } else {
                    echo "No data found for valet_r.";
                }
            } else {
                echo "Error in query for valet_r: " . $mysqli->error;
            }
            ?>
        </div>

        <div class="dataTableContainer">
            <h3>Regular Reservations Table</h3>
            <?php
            // Display regular reservations table
            if ($resultRegular) {
                if ($resultRegular->num_rows > 0) {
                    echo "<table class='dataTable'>";
                    $headerPrinted = false;

                    while ($row = $resultRegular->fetch_assoc()) {
                        if (!$headerPrinted) {
                            echo "<tr>";
                            foreach ($row as $columnName => $value) {
                                echo "<th>$columnName</th>";
                            }
                            echo "</tr>";
                            $headerPrinted = true;
                        }

                        echo "<tr>";
                        foreach ($row as $columnName => $value) {
                            echo "<td>$value</td>";
                        }
                        echo "</tr>";
                    }

                    echo "</table>";
                } else {
                    echo "No data found for regular_r.";
                }
            } else {
                echo "Error in query for regular_r: " . $mysqli->error;
            }
            ?>
        </div>

        
        <footer>
        <p>Masubay/Magaway 5⭐ Hotel Valet Parking Services. All rights reserved.</p>
        <p>ADMIN / MANAGER REPORTS</p>
        <p id="realTime"></p>

        <script>
            // JavaScript code to display real-time date and time
            function updateDateTime() {
                var now = new Date();
                var date = now.toDateString();
                var time = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                // Display date and time in the element with id "realTime"
                document.getElementById("realTime").innerText = "Current date and time: " + date + " " + time;

                // Update every minute (60000 milliseconds)
                setTimeout(updateDateTime, 60000);
            }

            // Call the function to start updating date and time
            updateDateTime();
        </script>
    </div>

    <!-- Exit and Print Buttons -->
    <ul class="exit-link">
        <li><a href="home.htm">Exit</a></li>
    </ul>
    <a class="print-btn" href="#" onclick="window.print()">Print</a>

</body>
</html>

<?php
$mysqli->close();
?>
