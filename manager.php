<?php
session_start();
include 'db.php'; // DB connection

// Add new manager
if(isset($_POST['add_manager'])){
    $employeeID = $_POST['employee_id'];

    $stmt = $conn->prepare("INSERT INTO MANAGER (Manager_ID) VALUES (?)");
    $stmt->bind_param("i", $employeeID);

    if($stmt->execute()){
        $msg = "Manager added successfully!";
    } else {
        $msg = "Error: ".$conn->error;
    }
}

// Delete manager
if(isset($_GET['delete'])){
    $managerID = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM MANAGER WHERE Manager_ID = ?");
    $stmt->bind_param("i", $managerID);
    $stmt->execute();
    header("Location: manager.php"); // Refresh page
}

// Fetch all managers with user info
$managers = $conn->query("
    SELECT m.Manager_ID, u.Name, u.Email, u.Number, e.Joining_date, e.Salary
    FROM MANAGER m
    JOIN EMPLOYEE e ON m.Manager_ID = e.Employee_ID
    JOIN USER u ON e.Employee_ID = u.User_ID
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manager Management</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { margin-top: 20px; }
    </style>
</head>
<body>
    <h2>Manager Management</h2>

    <?php if(isset($msg)) echo "<p>$msg</p>"; ?>

    <!-- Add Manager Form -->
    <form method="POST">
        <label>Select Employee to Promote as Manager:</label>
        <select name="employee_id" required>
            <?php
            $employees = $conn->query("
                SELECT e.Employee_ID, u.Name
                FROM EMPLOYEE e
                JOIN USER u ON e.Employee_ID = u.User_ID
                WHERE e.Employee_ID NOT IN (SELECT Manager_ID FROM MANAGER)
            ");
            while($row = $employees->fetch_assoc()):
            ?>
                <option value="<?= $row['Employee_ID'] ?>"><?= $row['Name'] ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="add_manager">Add Manager</button>
    </form>

    <!-- Manager Table -->
    <table>
        <tr>
            <th>Manager ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Joining Date</th>
            <th>Salary</th>
            <th>Action</th>
        </tr>
        <?php while($row = $managers->fetch_assoc()): ?>
        <tr>
            <td><?= $row['Manager_ID'] ?></td>
            <td><?= $row['Name'] ?></td>
            <td><?= $row['Email'] ?></td>
            <td><?= $row['Number'] ?></td>
            <td><?= $row['Joining_date'] ?></td>
            <td><?= $row['Salary'] ?></td>
            <td>
                <a href="manager.php?delete=<?= $row['Manager_ID'] ?>" onclick="return confirm('Are you sure?')">Remove</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
