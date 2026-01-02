<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['user_id'];

$result = $conn->query("
    SELECT USER.Name, USER.Email, USER.Number, USER.Address, CUSTOMER.Age, CUSTOMER.NID
    FROM USER
    JOIN CUSTOMER ON USER.User_ID = CUSTOMER.Customer_ID
    WHERE USER.User_ID = $id
");

$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Customer Profile</h2>

    <p><strong>Name:</strong> <?php echo $data['Name']; ?></p>
    <p><strong>Email:</strong> <?php echo $data['Email']; ?></p>
    <p><strong>Number:</strong> <?php echo $data['Number']; ?></p>
    <p><strong>Address:</strong> <?php echo $data['Address']; ?></p>
    <p><strong>Age:</strong> <?php echo $data['Age']; ?></p>
    <p><strong>NID:</strong> <?php echo $data['NID']; ?></p>

    <br>
    <a href="dashboard.php">← Back to Dashboard</a>
</div>

</body>
</html>