<?php
$otp = isset($_GET['otp']) ? htmlspecialchars($_GET['otp']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Booking!</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url(BGSUCCESS.jpg);
            background-size: cover;
            text-align: center;
        }
        header {
            font-size: 18px;
            background-color: #3a3939;
            color: #26cad6;
            padding: 1px 3px;
            text-align: center;
            margin-bottom: 10px;
        }
        .date-time {
            position: fixed;
            top: 20px;
            left: 20px;
            font-size: 24px;
            color: skyblue;
            font-weight: bold;
            background-color: #6e6c6c;
            padding: 10px 15px;
            border-radius: 5px;
            box-shadow: 0 10px 19px skyblue;
        }
        .container {
            opacity: 0.95;
            padding: 30px;
            background-color: skyblue;
            margin: 50px auto;
            max-width: 650px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        h1 {
            color: #28a745;
            font-size: 1.7em;
        }
        p {
            font-size: 15px;
            line-height: 1.5;
        }
        .giveaway {
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border: 2px dashed #007bff;
            border-radius: 10px;
        }
        .giveaway h3 {
            color: #007bff;
        }
        .otp-box {
            background-color: #fff;
            padding: 15px;
            margin-top: 15px;
            border: 2px dashed green;
            color: green;
            font-size: 1.2em;
            font-weight: bold;
            border-radius: 8px;
        }
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
        }
        .button:hover {
            background-color: lawngreen;
            color: #000;
        }
    </style>
    <script>
        function updateDateTime() {
            const now = new Date();
            document.getElementById("current-date").innerText = now.toLocaleDateString();
            document.getElementById("current-time").innerText = now.toLocaleTimeString();
        }
        setInterval(updateDateTime, 1000);
        window.onload = updateDateTime;
    </script>
</head>
<body>
    <header>
        <h1>Azure Haven Beach Resort Room Reservation</h1>
    </header>
    <div class="date-time">
        <div id="current-date"></div>
        <div id="current-time"></div>
    </div>
    <div class="container">
        <h1>🎉 You have Successfully booked your room! 🎉</h1>
        <p>Thank you for booking in Beach Resort Room Reservation</p>

        <?php if (!empty($otp)): ?>
        <div class="otp-box">
            Your Booking OTP: <strong><?php echo $otp; ?></strong><br>
            Please keep this OTP for verification purposes!
        </div>
        <?php endif; ?>

        <div class="giveaway">
            <h3>🎁 Special Giveaway Just for You!</h3>
            <p>As a token of our appreciation, you’ll receive: a souvenir keychain exclusive from us! 🥰</p>
            <ul style="text-align: left;">
                <li>✅ Please wait for the Email Confirmation for your booking</li>
                <li>✅ Please feel free to contact us for your inquiries</li>
                <li>✅ Please enjoy your stay with us 🥰</li>
            </ul>
            <p>Keep an eye on your email for more details about claiming your giveaway!</p>
        </div>
        <a href="home.html" class="button">Return to Home</a>
    </div>
</body>
</html>
