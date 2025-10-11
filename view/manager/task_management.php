<?php
session_start();
require_once("../../model/db.php");

if (!isset($_SESSION['userId']) || $_SESSION['RoleId'] != 3) {
    header("Location: ../login.php");
    exit;
}

$conn = getConnection();

//  new Task Assignment add
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $taskType = $_POST["task_type"];
    $status = "Pending";
    $deadline = $_POST["deadline"];
    $assignedTo = intval($_POST["assigned_to"]);
    $assignedBy = $_SESSION["userId"];

    $insertTask = "INSERT INTO task (task_type, status, deadline, completion_rate, assigned_date)
                   VALUES ('$taskType', '$status', '$deadline', 0.00, NOW())";
    mysqli_query($conn, $insertTask);
    $taskId = mysqli_insert_id($conn);

    mysqli_query($conn, "INSERT INTO task_assignment (taskID, assigned_By, assigned_To)
                         VALUES ($taskId, $assignedBy, $assignedTo)");
}

// employees listing view
$employees = mysqli_query($conn, "SELECT userId, Name FROM user WHERE RoleId = 4");

// get all tasks assigned by any particular manager
$sql = "SELECT t.taskID, t.task_type, t.status, t.deadline, t.completion_rate, u.Name AS employee
        FROM task t
        JOIN task_assignment ta ON t.taskID = ta.taskID
        JOIN user u ON ta.assigned_To = u.userId
        WHERE ta.assigned_By = " . $_SESSION['userId'];

$tasks = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Task Management</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        form { margin-bottom: 30px; }
        label { display: block; margin-top: 10px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background: #f4f4f4; }
    </style>
</head>
<body>
<h1>Task Management</h1>
<a href="home.php">← Back to Home</a>

<h2>Assign New Task</h2>
<form method="POST">
    <label>Task Type:</label>
    <input type="text" name="task_type" required>

    <label>Deadline:</label>
    <input type="date" name="deadline" required>

    <label>Assign To:</label>
    <select name="assigned_to" required>
        <?php while ($emp = mysqli_fetch_assoc($employees)): ?>
            <option value="<?= $emp['userId'] ?>"><?= htmlspecialchars($emp['Name']) ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <button type="submit">Assign Task</button>
</form>

<h2>All Assigned Tasks</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Task</th>
        <th>Assigned To</th>
        <th>Status</th>
        <th>Deadline</th>
        <th>Completion</th>
    </tr>
    <?php while ($t = mysqli_fetch_assoc($tasks)): ?>
        <tr>
            <td><?= $t['taskID'] ?></td>
            <td><?= htmlspecialchars($t['task_type']) ?></td>
            <td><?= htmlspecialchars($t['employee']) ?></td>
            <td><?= htmlspecialchars($t['status']) ?></td>
            <td><?= htmlspecialchars($t['deadline']) ?></td>
            <td><?= htmlspecialchars($t['completion_rate']) ?>%</td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
