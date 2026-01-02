<?php
session_start();

/* 🔐 Protect page */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

/* 📦 Initialize booking session ONLY ONCE */
if (!isset($_SESSION['booking'])) {
    $_SESSION['booking'] = [
        'destination_id' => null,
        'date' => null,
        'people' => null,
        'transport_id' => null,
        'payment_done' => false
    ];
}

/* 🔌 Database connection */
$conn = new mysqli("localhost", "root", "", "travel_system");
if ($conn->connect_error) {
    die("Database connection failed");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book a Trip</title>
    <link rel="stylesheet" href="style.css/decor.css">
</head>
<body>

<div class="container">
    <h2>📍 Start Your Booking</h2>

    <!-- ❗ Incomplete warning -->
    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;">⚠ Please complete all required fields</p>
    <?php endif; ?>

    <form method="POST" action="book_process.php">

        <!-- Destination -->
        <label>Destination</label>
        <select name="destination_id" required>
            <option value="">-- Select Destination --</option>
            <?php
            $destinations = $conn->query("SELECT * FROM Destination");
            while ($d = $destinations->fetch_assoc()):
            ?>
                <option value="<?= $d['DestinationID'] ?>">
                    <?= $d['City'] ?>, <?= $d['Country'] ?>
                    (<?= $d['Duration'] ?> days)
                </option>
            <?php endwhile; ?>
        </select>

        <!-- Travel Date -->
        <label>Travel Date</label>
        <input type="date" name="date" required>

        <!-- Number of People -->
        <label>Number of People</label>
        <input type="number" name="people" min="1" required>

        <button type="submit">Next → Select Transport</button>
    </form>

    <br>
    <a href="dashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>
