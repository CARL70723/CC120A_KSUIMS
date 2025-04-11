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

// Create transactions table if not exists
$conn->query("CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    contact VARCHAR(20) NOT NULL,
    item_name VARCHAR(255) NOT NULL,
    price_per_day DECIMAL(10,2) NOT NULL,
    checkin_date DATE NOT NULL,
    checkout_date DATE NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    transaction_otp VARCHAR(6) NOT NULL
)");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = htmlspecialchars(trim($_POST['full_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $contact = htmlspecialchars(trim($_POST['contact']));
    $item_name = htmlspecialchars(trim($_POST['item_name']));
    $price_per_day = floatval($_POST['price_per_day']);
    $checkin_date = $_POST['checkin_date'];
    $checkout_date = $_POST['checkout_date'];
    $payment_method = htmlspecialchars(trim($_POST['payment_method']));

    $date1 = new DateTime($checkin_date);
    $date2 = new DateTime($checkout_date);
    $interval = $date1->diff($date2);
    $days = $interval->days;

    if ($days < 1) {
        echo "<script>alert('Checkout date must be after check-in date!'); window.history.back();</script>";
        exit();
    }

    $total_price = $days * $price_per_day;

    // Generate 6-digit OTP
    $transaction_otp = strval(rand(100000, 999999));

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO transactions (full_name, email, contact, item_name, price_per_day, checkin_date, checkout_date, total_price, payment_method, transaction_otp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssdssdss", $full_name, $email, $contact, $item_name, $price_per_day, $checkin_date, $checkout_date, $total_price, $payment_method, $transaction_otp);
    $stmt->execute();
    $stmt->close();

    echo "<script>window.location.href='success.php?otp=$transaction_otp';</script>";
    exit();
}

// Prefill from URL if available
$prefill_name = isset($_GET['car']) ? htmlspecialchars($_GET['car']) : '';
$prefill_price = isset($_GET['price']) ? floatval(preg_replace("/[^\d.]/", "", $_GET['price'])) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction Page</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: skyblue; }
        .container { background: white; padding: 20px; width: 50%; margin: auto; border-radius: 10px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); }
        h2 { color: dodgerblue; }
        form input, form select, form button { width: 80%; padding: 10px; margin: 10px; border-radius: 5px; border: 1px solid skyblue; font-size: 16px; }
        form button { background-color: dodgerblue; color: white; cursor: pointer; }
        form button:hover { background-color: lime; color: black; }
    </style>
    <script>
        function calculateTotal() {
            const checkin = new Date(document.getElementById("checkin_date").value);
            const checkout = new Date(document.getElementById("checkout_date").value);
            const pricePerDay = parseFloat(document.getElementById("price_per_day").value);
            const total = document.getElementById("total_price");

            if (checkout > checkin) {
                const days = (checkout - checkin) / (1000 * 60 * 60 * 24);
                total.innerText = "Total Price: ₱" + (days * pricePerDay).toFixed(2);
            } else {
                total.innerText = "Invalid date selection";
            }
        }
    </script>
</head>
<body onload="calculateTotal()">
    <div class="container">
        <h2>Transaction Details</h2>
        <form action="transaction.php" method="POST">
            <input type="text" name="full_name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="text" name="contact" placeholder="Contact #" required>
            <input type="text" name="item_name" placeholder="Item Name" value="<?php echo $prefill_name; ?>" required>
            <input type="number" id="price_per_day" name="price_per_day" placeholder="Price per Day" value="<?php echo $prefill_price; ?>" required>
            <input type="date" id="checkin_date" name="checkin_date" onchange="calculateTotal()" required>
            <input type="date" id="checkout_date" name="checkout_date" onchange="calculateTotal()" required>
            <select name="payment_method" required>
                <option value="" disabled selected>Select Payment Method</option>
                <option value="cash">Cash Transaction</option>
                <option value="credit-card">Credit Card</option>
                <option value="paypal">PayPal</option>
                <option value="bank-transfer">Bank Transfer</option>
            </select>
            <h3 id="total_price">Total Price: ₱0.00</h3>
            <button type="submit">Complete Booking</button>
        </form>
    </div>
</body>
</html>
