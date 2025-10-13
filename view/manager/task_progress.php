<?php
session_start();
require_once("../../model/db.php");

if (!isset($_SESSION['userId']) || $_SESSION['RoleId'] != 3) {
    header("Location: ../login.php");
    exit;
}

$conn = getConnection();

// we are getting the tasks assigned by manager here
$sql = "SELECT t.taskID, t.task_type, t.status, t.completion_rate, t.deadline,
               u.Name AS employee
        FROM task t
        JOIN task_assignment ta ON t.taskID = ta.taskID
        JOIN user u ON ta.assigned_To = u.userId
        WHERE ta.assigned_By = " . $_SESSION['userId'];

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Task Progress</title>
    
<link rel="stylesheet" href="../css/managercss/common.css">
<link rel="stylesheet" href="../css/managercss/task_progress.css">
</head>
<body>
<h1>Task Progress</h1>
	        <li><?php echo "<a href='home.php'>Home</a>" ?></li>
            <li ><?php echo "<a href='profile.php'>Profile</a>" ?></li>
            <li><?php echo "<a href='../logout.php'>logout</a>" ?></li>
<table>
    <tr>
        <th>ID</th>
        <th>Task</th>
        <th>Assigned To</th>
        <th>Status</th>
        <th>Completion Rate</th>
        <th>Deadline</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['taskID'] ?></td>
            <td><?= htmlspecialchars($row['task_type']) ?></td>
            <td><?= htmlspecialchars($row['employee']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td>
                <div class="progress-bar">
                    <div class="progress" style="width: <?= $row['completion_rate'] ?>%">
                        <?= $row['completion_rate'] ?>%
                    </div>
                </div>
            </td>
            <td><?= htmlspecialchars($row['deadline']) ?></td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
