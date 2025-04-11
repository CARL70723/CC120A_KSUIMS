<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$database = "masubay/magaway_parking_reservations";

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

function authenticateUser($inputUsername, $inputPassword, $userType, $mysqli) {
    $stmt = $mysqli->prepare("SELECT user_type FROM admins WHERE username = ? AND password = ? AND user_type = ?");
    $stmt->bind_param("sss", $inputUsername, $inputPassword, $userType);

    $stmt->execute();
    $stmt->bind_result($authenticatedUserType);
    $stmt->fetch();
    $stmt->close();

    return $authenticatedUserType;
}

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['user_type'])) {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];
    $userType = $_POST['user_type'];

    $authenticatedUserType = authenticateUser($inputUsername, $inputPassword, $userType, $mysqli);

    if ($authenticatedUserType) {
        $_SESSION['authenticated'] = true;
        $_SESSION['user_type'] = $authenticatedUserType;

        if ($authenticatedUserType == 'admin') {
            header("Location: admin_dashboard.php");
            exit();
        } elseif ($authenticatedUserType == 'manager') {
            header("Location: manager_dashboard.php");
            exit();
        } elseif ($authenticatedUserType == 'masterlist') {
            header("Location: masterlist_dashboard.php");
            exit();
        } else {
            echo "Invalid user type";
        }
    } else {
        echo "Invalid username or password";
    }
} else {
    echo "Invalid request";
}

$mysqli->close();
?>
