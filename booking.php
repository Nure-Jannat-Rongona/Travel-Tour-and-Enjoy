<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['user_id'];

$result = $conn->query("
    SELECT * FROM Booking
    WHERE CustomerID = $id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bookings</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Create Booking</h2>

    <form action="booking_process.php" method="POST">
        <input type="date" name="date" required>
        <input type="number" name="people" placeholder="Number of People" required>
        <button type="submit">Book</button>
    </form>

    <hr>

    <h3>Your Bookings</h3>

    <?php if ($result->num_rows > 0) { ?>
        <table>
            <tr>
                <th>Booking ID</th>
                <th>Date</th>
                <th>People</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['BookingID']; ?></td>
                <td><?php echo $row['Date']; ?></td>
                <td><?php echo $row['NumberOfPeople']; ?></td>
            </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No bookings yet.</p>
    <?php } ?>

    <br>
    <a href="dashboard.php">← Back to Dashboard</a>
</div>

</body>
</html>