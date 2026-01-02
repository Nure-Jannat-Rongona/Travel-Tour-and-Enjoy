<?php
// Start the session
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "travel_system");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare SQL to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM user WHERE Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // Plain-text password check
    if ($password === $row['Password']) {
        // Login success
        $_SESSION['user_id'] = $row['User_ID'];
        $_SESSION['user_name'] = $row['Name'];
        header("Location: dashboard.php"); // redirect to your dashboard
        exit();
    } else {
        // Wrong password
        echo "<script>alert('Invalid password!'); window.location='login.php';</script>";
        exit();
    }
} else {
    // Email not found
    echo "<script>alert('Email not found!'); window.location='login.php';</script>";
    exit();
}

$stmt->close();
$conn->close();
?>
