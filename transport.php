<?php
session_start();
$conn = new mysqli("localhost", "root", "", "travel_system");

if (!isset($_SESSION['booking']['destination_id'])) {
    header("Location: book.php");
    exit();
}

$result = $conn->query("SELECT * FROM Transport");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Select Transport</title>
    <link rel="stylesheet" href="style.css/decor.css">
</head>
<body>

<div class="container">
    <h2>Select Transport</h2>

    <form method="POST" action="transport_process.php">
        <?php while ($t = $result->fetch_assoc()): ?>
            <label>
                <input type="radio" name="transport_id"
                       value="<?= $t['TransportID'] ?>" required>
                <?= $t['Type'] ?> —
                ৳<?= $t['Cost'] ?>
            </label><br>
        <?php endwhile; ?>

        <button type="submit">Next → Payment</button>
    </form>
</div>

</body>
</html>
