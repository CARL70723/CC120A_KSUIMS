<?php
$mysqli = new mysqli("localhost", "root", "", "beach_resort");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$query = "SELECT * FROM transactions";
$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
       body {
            font-family: 'Times New Roman';
            margin: 1px;
            margin-left: 150px;
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
            max-width: 900px;
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
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 40px;
        }th, td {
            padding: 8px;
            border: 2px solid #007BFF;
            text-align: left;
            font-size: 14px;
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
            font-family: tahoma;
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
            margin-right: 30px;
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
        }

        .edit-btn:hover,
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
            <h1>Beach Resort⭐ Transaction Services</h1>
            <h2>ALL BOOKINGS</h2>
        </header>

        <?php
if ($result->num_rows > 0) {
    echo "<table class='dataTable'>";

    // Print table headers
    $headerPrinted = false; // Flag to ensure headers are printed only once
    while ($row = $result->fetch_assoc()) {
        if (!$headerPrinted) {
            echo "<tr>";
            foreach ($row as $columnName => $value) {
                echo "<th>$columnName</th>";
            }
            echo "<th>Actions</th>"; // Add Actions column
            echo "</tr>";
            $headerPrinted = true;
        }
    
        // Print data rows
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>$value</td>";
        }
        echo "<td>
                <a class='edit-btn' href='edit_user.php?id=" . $row['id'] . "'>Edit</a>
                <button class='delete-btn' onclick='deleteUser(" . $row['id'] . ")'>Delete</button>
              </td>";
        echo "</tr>";
    }
    
    echo "</table>";
    } else {
        echo "No data found.";
    }
    
$mysqli->close();
?>

<footer>
        <p>Beach Resort ⭐ Transactions Services. All rights reserved.</p>
        <p>ADMIN DASHBOARD</p>
        <p id="realTime"></p>

        <script>
            // JavaScript code to display real-time date and time
            function updateDateTime() {
                var now = new Date();
                var date = now.toDateString();
                var time = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                // Display date and time in the element with id "realTime"
                document.getElementById("realTime").innerText = "Current date and time:  " + date + " " + time;

                // Update every minute (60000 milliseconds)
                setTimeout(updateDateTime, 60000);
            }

            // Call the function to start updating date and time
            updateDateTime();
        </script>
    </footer>
        <div class="dataTableContainer">
            
           
           <?php
           // Your existing regular reservations code...
           ?>
       </div>
   </div>
    <ul class="exit-link">
       <li><a href="home.htm">EXIT</a></li>
   </ul>

        <script>
            function editUser(id) {
                // Handle edit functionality using the 'id' parameter
                alert("Edit functionality for user with ID " + id + " to be implemented.");
            }
            
            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function deleteUser(id) {
        var confirmDelete = confirm("Are you sure you want to delete this user?");
        if (confirmDelete) {
            // Send an AJAX request to delete the user
            jQuery.ajax({
                type: "POST",
                url: "delete_user.php",
                data: { id: id },
                success: function(response) {
                    alert(response); // Display the response from the server
                    // Optionally, you can reload the page to reflect changes
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    }
</script>

    </div>
</body>
</html>