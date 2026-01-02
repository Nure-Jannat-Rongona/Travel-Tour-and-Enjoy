<?php
session_start();
include 'db.php'; // Your DB connection

// Add new budget
if(isset($_POST['add_budget'])){
    $budgetRange = $_POST['budget_range'];

    $stmt = $conn->prepare("INSERT INTO Budget (BudgetRange) VALUES (?)");
    $stmt->bind_param("s", $budgetRange);

    if($stmt->execute()){
        $msg = "Budget added successfully!";
    } else {
        $msg = "Error: " . $conn->error;
    }
}

// Delete budget
if(isset($_GET['delete'])){
    $budgetID = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM Budget WHERE BudgetID = ?");
    $stmt->bind_param("i", $budgetID);
    $stmt->execute();
    header("Location: budget.php"); // Refresh page
}

// Fetch all budgets
$budgets = $conn->query("SELECT * FROM Budget");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Budget Management</title>
    <style>
        table { border-collapse: collapse; width: 50%; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { margin-top: 20px; }
    </style>
</head>
<body>
    <h2>Budget Management</h2>

    <?php if(isset($msg)) echo "<p>$msg</p>"; ?>

    <!-- Add Budget Form -->
    <form method="POST">
        <label>New Budget Range:</label>
        <input type="text" name="budget_range" required>
        <button type="submit" name="add_budget">Add Budget</button>
    </form>

    <!-- Budget Table -->
    <table>
        <tr>
            <th>Budget ID</th>
            <th>Budget Range</th>
            <th>Action</th>
        </tr>
        <?php while($row = $budgets->fetch_assoc()): ?>
        <tr>
            <td><?= $row['BudgetID'] ?></td>
            <td><?= $row['BudgetRange'] ?></td>
            <td>
                <a href="budget.php?delete=<?= $row['BudgetID'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
