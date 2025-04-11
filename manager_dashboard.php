

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
            margin-left: 65px;
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
            padding: 10px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
            max-width: 1000px;
            width: 100%;
            margin-left: 50px; /* Adjusted margin to move it to the left */
            margin-bottom: 30px;
        }header {
            background-color: rgb(149, 243, 238);
            color: black; /* Set header text color to white */
            padding: 1px;
            border-radius: 10px 10px 0 0;
            margin-bottom: 35px; /* Added margin for spacing */
        } footer {
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
            padding: 4px 35px;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 40px;
        }th, td {
            padding: 4px 6px;
            border: 2px solid #007BFF;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #007BFF;
            color: black; 
            font-weight: bold;
            font-size: 2em;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        h2 {
            text-decoration: underline;
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
            .exit-link {
            position: fixed;
            bottom: 270px;
            right: 0px;
            list-style: none;
            margin-right: 17px;
            padding: 0;
        }

        .exit-link li {
            display: inline-block;
            margin-left: 10px;
        }

        .exit-link a {
            display: block;
            padding: 4px 20px;
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

       
        }.edit-btn,
        .delete-btn {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 5px;
            font-size: 0.9em;
        }.edit-btn:hover,
        .delete-btn:hover {
            background-color: #0056b3;
        }.edit-btn,
        .delete-btn {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 6px 10px;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 5px;
            font-size: 0.9em;
        }

        .edit-btn:hover,
        .delete-btn:hover {
            background-color:  #69e630;
        }
    </style>
</head>
<body>
<div class="container">
<header>
            <h1>Masubay/Magaway 5⭐ Hotel Valet Parking Services</h1>
            <h2>ALL RESERVATIONS</h2>
        </header>

    <!-- Valet Reservations Table -->
    <div class="dataTableContainer">
    <h3>Valet Reservations Table</h3>
    <?php
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
                    echo "<th>Actions</th>"; // Add Actions column
                    echo "</tr>";
                    $headerPrinted = true;
                }
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>$value</td>";
                }
                echo "<td>
                        <a class='edit-btn' href='edit_valet_r.php?id=" . $row['id'] . "'>Edit</a>
                        <button class='delete-btn' onclick='deleteReservation(" . $row['id'] . ", \"valet_r\")'>Delete</button>
                      </td>";
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

<!-- Regular Reservations Table -->
<div class="dataTableContainer">
    <h3>Regular Reservations Table</h3>
    <?php
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
                    echo "<th>Actions</th>"; // Add Actions column
                    echo "</tr>";
                    $headerPrinted = true;
                }

                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>$value</td>";
                }
                echo "<td>
                        <a class='edit-btn' href='edit_regular_r.php?id=" . $row['id'] . "'>Edit</a>
                        <button class='delete-btn' onclick='deleteReservation(" . $row['id'] . ", \"regular_r\")'>Delete</button>
                      </td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No data found for regular reservations.";
        }
    } else {
        echo "Error in query for regular reservations: " . $mysqli->error;
    }
    ?>
</div>

<footer>
        <p>Masubay/Magaway 5⭐ Hotel Valet Parking Services. All rights reserved.</p>
        <p>MANAGER DASHBOARD</p>
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

<!-- Regular Reservations Table -->
<div class="dataTableContainer">
    <?php
    // Your existing regular reservations code...
    ?>
</div>

<ul class="exit-link">
    <li><a href="home.htm">EXIT</a></li>
</ul>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function deleteReservation(id, table) {
        var confirmDelete = confirm("Are you sure you want to delete this reservation?");
        if (confirmDelete) {
            $.ajax({
                type: "POST",
                url: "delete_reservation.php",
                data: { id: id, table: table },
                success: function(response) {
                    alert(response);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    }
</script>

    
</body>
</html>