<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Travel System</title>
    <link rel="stylesheet" href="style.css/decor.css">
</head>
<body>

<div class="container">
    <h1>Hi <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'User'; ?>!</h1>

    <p>What would you like to manage today?</p>

    <div class="nav">
        <a href="customer.php">👤 Customer Info</a>
        <a href="book.php">📅 Bookings</a>
        <a href="transport.php">🚌 Transport</a>
        <a href="logout.php">🚪 Logout</a>
    </div>
</div>

</body>
</html>