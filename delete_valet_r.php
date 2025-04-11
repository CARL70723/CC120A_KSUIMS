<?php
$mysqli = new mysqli("localhost", "root", "", "masubay/magaway_parking_reservations");

// Check if ID is provided through POST request
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Delete valet reservation based on the provided ID
    $query = "DELETE FROM valet_reservations WHERE id = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Valet reservation deleted successfully.";
        } else {
            echo "No valet reservation found with the provided ID.";
        }

        $stmt->close();
    } else {
        echo "Error in preparing the valet reservation deletion query: " . $mysqli->error;
    }
} else {
    echo "No valet reservation ID provided for deletion.";
}

// Close the database connection
$mysqli->close();
?>
