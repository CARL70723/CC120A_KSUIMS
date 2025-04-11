<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beach_resort";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['checkin_date']) && isset($_POST['checkout_date'])) {
    $checkin_date = $_POST['checkin_date'];
    $checkout_date = $_POST['checkout_date'];

    // Query to get available rooms based on selected check-in and check-out dates
    $sql = "SELECT room_name 
            FROM rooms 
            WHERE room_id NOT IN (
                SELECT room_id 
                FROM transactions 
                WHERE (checkin_date < ? AND checkout_date > ?)
            ) AND status = 'available'";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $checkin_date, $checkout_date);
    $stmt->execute();
    $result = $stmt->get_result();

    $available_rooms = [];
    while ($row = $result->fetch_assoc()) {
        $available_rooms[] = $row['room_name'];
    }

    // Send back the available rooms
    echo json_encode($available_rooms);
    exit;
}
?>
