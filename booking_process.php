<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$customerID = $_SESSION['user_id'];
$date = $_POST['date'];
$people = $_POST['people'];

$sql = "INSERT INTO Booking (CustomerID, Date, NumberOfPeople)
        VALUES ($customerID, '$date', $people)";

if ($conn->query($sql)) {
    echo "Booking successful! <br>";
    echo "<a href='dashboard.php'>Back to Dashboard</a>";
} else {
    echo "Error: " . $conn->error;
}
?>