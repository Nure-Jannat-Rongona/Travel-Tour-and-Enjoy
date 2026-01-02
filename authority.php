<?php
session_start();
include 'db.php'; // DB connection

// Add new authority
if(isset($_POST['add_authority'])){
    $employeeID = $_POST['employee_id'];

    $stmt = $conn->prepare("INSERT INTO AUTHORITY (Authority_ID) VALUES (?)");
    $stmt->bind_param("i", $employeeID);

    if($stmt->execute()){
        $msg = "Authority added successfully!";
    } else {
        $msg = "Error: ".$conn->error;
    }
}

// Delete authority
if(isset($_GET['delete'])){
    $authorityID = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM AUTHORITY WHERE Authority_ID = ?");
    $stmt->bind_param("i", $authorityID);
    $stmt->execute();
    header("Location: authority.php"); // Refresh page
}

// Fetch all authorities with employee info
$authorities = $conn->query("
    SELECT a.Authority_ID, u.Name, u.Email, u.Number, e.Joining_date, e.Salary
    FROM AUTHORITY a
    JOIN EMPLOYEE e ON a.Authority_ID = e.Employee_ID
    JOIN USER u ON e.Employee_ID = u.User_ID
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Authority Management</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { margin-top: 20px; }
    </style>
</head>
<body>
    <h2>Authority Management (Hiring Rights)</h2>

    <?php if(isset($msg)) echo "<p>$msg</p>"; ?>

    <!-- Add Authority Form -->
    <form method="POST">
        <label>Select Employee to Give Hiring Authority:</label>
        <select name="employee_id" required>
            <?php
            $employees = $conn->query("
                SELECT e.Employee_ID, u.Name
                FROM EMPLOYEE e
                JOIN USER u ON e.Employee_ID = u.User_ID
                WHERE e.Employee_ID NOT IN (SELECT Authority_ID FROM AUTHORITY)
            ");
            while($row = $employees->fetch_assoc()):
            ?>
                <option value="<?= $row['Employee_ID'] ?>"><?= $row['Name'] ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="add_authority">Add Authority</button>
    </form>

    <!-- Authority Table -->
    <table>
        <tr>
            <th>Authority ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Joining Date</th>
            <th>Salary</th>
            <th>Action</th>
        </tr>
        <?php while($row = $authorities->fetch_assoc()): ?>
        <tr>
            <td><?= $row['Authority_ID'] ?></td>
            <td><?= $row['Name'] ?></td>
            <td><?= $row['Email'] ?></td>
            <td><?= $row['Number'] ?></td>
            <td><?= $row['Joining_date'] ?></td>
            <td><?= $row['Salary'] ?></td>
            <td>
                <a href="authority.php?delete=<?= $row['Authority_ID'] ?>" onclick="return confirm('Are you sure?')">Remove</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
