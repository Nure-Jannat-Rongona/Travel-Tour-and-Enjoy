<?php
session_start();
include 'db.php'; // DB connection

// Add new accountant
if(isset($_POST['add_accountant'])){
    $employeeID = $_POST['employee_id'];

    $stmt = $conn->prepare("INSERT INTO ACCOUNTANT (Accountant_ID) VALUES (?)");
    $stmt->bind_param("i", $employeeID);

    if($stmt->execute()){
        $msg = "Accountant added successfully!";
    } else {
        $msg = "Error: ".$conn->error;
    }
}

// Delete accountant
if(isset($_GET['delete'])){
    $accountantID = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM ACCOUNTANT WHERE Accountant_ID = ?");
    $stmt->bind_param("i", $accountantID);
    $stmt->execute();
    header("Location: accountant.php"); // Refresh page
}

// Fetch all accountants with user info
$accountants = $conn->query("
    SELECT a.Accountant_ID, u.Name, u.Email, u.Number, e.Joining_date, e.Salary
    FROM ACCOUNTANT a
    JOIN EMPLOYEE e ON a.Accountant_ID = e.Employee_ID
    JOIN USER u ON e.Employee_ID = u.User_ID
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Accountant Management</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { margin-top: 20px; }
    </style>
</head>
<body>
    <h2>Accountant Management</h2>

    <?php if(isset($msg)) echo "<p>$msg</p>"; ?>

    <!-- Add Accountant Form -->
    <form method="POST">
        <label>Select Employee to Promote as Accountant:</label>
        <select name="employee_id" required>
            <?php
            $employees = $conn->query("
                SELECT e.Employee_ID, u.Name
                FROM EMPLOYEE e
                JOIN USER u ON e.Employee_ID = u.User_ID
                WHERE e.Employee_ID NOT IN (SELECT Accountant_ID FROM ACCOUNTANT)
            ");
            while($row = $employees->fetch_assoc()):
            ?>
                <option value="<?= $row['Employee_ID'] ?>"><?= $row['Name'] ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="add_accountant">Add Accountant</button>
    </form>

    <!-- Accountant Table -->
    <table>
        <tr>
            <th>Accountant ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Joining Date</th>
            <th>Salary</th>
            <th>Action</th>
        </tr>
        <?php while($row = $accountants->fetch_assoc()): ?>
        <tr>
            <td><?= $row['Accountant_ID'] ?></td>
            <td><?= $row['Name'] ?></td>
            <td><?= $row['Email'] ?></td>
            <td><?= $row['Number'] ?></td>
            <td><?= $row['Joining_date'] ?></td>
            <td><?= $row['Salary'] ?></td>
            <td>
                <a href="accountant.php?delete=<?= $row['Accountant_ID'] ?>" onclick="return confirm('Are you sure?')">Remove</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
