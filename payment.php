<?php
session_start();
$conn = new mysqli("localhost", "root", "", "travel_system");

$b = $_SESSION['booking'];

if (!$b['transport_id']) {
    header("Location: transport.php");
    exit();
}

/* Fetch prices */
$d = $conn->query("SELECT BasePrice FROM Destination WHERE DestinationID=".$b['destination_id'])->fetch_assoc();
$t = $conn->query("SELECT Cost FROM Transport WHERE TransportID=".$b['transport_id'])->fetch_assoc();

$total = ($d['BasePrice'] + $t['Cost']) * $b['people'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
    <link rel="stylesheet" href="style.css/decor.css">
</head>
<body>

<div class="container">
    <h2>Payment</h2>

    <p><strong>Total Amount:</strong> ৳<?= $total ?></p>

    <form method="POST" action="payment_process.php">
        <label>
            <input type="radio" name="method" value="bKash" required> bKash
        </label><br>

        <label>
            <input type="radio" name="method" value="Nagad"> Nagad
        </label><br>

        <label>
            <input type="radio" name="method" value="Card"> Card
        </label><br>

        <button type="submit">Confirm Payment</button>
    </form>
</div>

</body>
</html>
