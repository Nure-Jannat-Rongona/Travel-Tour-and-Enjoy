<?php
session_start();
$conn = new mysqli("localhost", "root", "", "travel_system");

$b = $_SESSION['booking'] ?? null;

if (!$b || !$b['destination_id'] || !$b['transport_id'] || !$b['payment_done']) {
    die("<h2 style='text-align:center;color:red;margin-top:50px;'>Booking incomplete. Please complete all steps.</h2>");
}

/* Insert booking */
$stmt = $conn->prepare("
    INSERT INTO Booking
    (CustomerID, DestinationID, Date, NumberOfPeople, TransportID)
    VALUES (?, ?, ?, ?, ?)
");
$stmt->bind_param(
    "iisii",
    $_SESSION['user_id'],
    $b['destination_id'],
    $b['date'],
    $b['people'],
    $b['transport_id']
);
$stmt->execute();
$bookingID = $stmt->insert_id;

/* Insert payment */
$conn->query("
INSERT INTO Payment (BookingID, Method, Status, Amount)
VALUES ($bookingID, '".$b['payment_method']."', 'Paid', 0)
");

/* Clear session */
unset($_SESSION['booking']);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmed</title>
    <link rel="stylesheet" href="style.css/decor.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .confirmation {
            text-align: center;
            background-color: #4CAF50;
            color: white;
            padding: 50px 80px;
            border-radius: 12px;
            box-shadow: 0px 8px 20px rgba(0,0,0,0.2);
        }
        .confirmation h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .confirmation a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            background-color: white;
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
            border-radius: 6px;
        }
        .confirmation a:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

<div class="confirmation">
    <h1>🎉 Booking Confirmed!</h1>
    <p>Your trip has been successfully booked.</p>
    <a href="dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>
