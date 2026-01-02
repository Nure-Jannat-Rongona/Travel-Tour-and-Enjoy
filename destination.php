<?php
session_start();
include 'db.php'; // Your DB connection

// Add a new destination
if(isset($_POST['add_destination'])){
    $country = $_POST['country'];
    $city = $_POST['city'];
    $duration = $_POST['duration'];

    $stmt = $conn->prepare("INSERT INTO Destination (Country, City, Duration) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $country, $city, $duration);

    if($stmt->execute()){
        $msg = "Destination added successfully!";
    } else {
        $msg = "Error: ".$conn->error;
    }
}

// Delete destination
if(isset($_GET['delete'])){
    $destID = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM Destination WHERE DestinationID = ?");
    $stmt->bind_param("i", $destID);
    $stmt->execute();
    header("Location: destination.php");
}

// Fetch all destinations
$destinations = $conn->query("SELECT * FROM Destination");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Destination Management</title>
    <style>
        table { border-collapse: collapse; width: 70%; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { margin-top: 20px; }
    </style>
</head>
<body>
    <h2>Destination Management</h2>

    <?php if(isset($msg)) echo "<p>$msg</p>"; ?>

    <!-- Add Destination Form -->
    <form method="POST">
        <label>Country:</label>
        <input type="text" name="country" required>
        <br><br>

        <label>City:</label>
        <input type="text" name="city" required>
        <br><br>

        <label>Duration:</label>
        <input type="text" name="duration" placeholder="e.g., 3 days 2 nights" required>
        <br><br>

        <button type="submit" name="add_destination">Add Destination</button>
    </form>

    <!-- Destination Table -->
    <table>
        <tr>
            <th>ID</th>
            <th>Country</th>
            <th>City</th>
            <th>Duration</th>
            <th>Action</th>
        </tr>
        <?php while($row = $destinations->fetch_assoc()): ?>
        <tr>
            <td><?= $row['DestinationID'] ?></td>
            <td><?= $row['Country'] ?></td>
            <td><?= $row['City'] ?></td>
            <td><?= $row['Duration'] ?></td>
            <td>
                <a href="destination.php?delete=<?= $row['DestinationID'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
