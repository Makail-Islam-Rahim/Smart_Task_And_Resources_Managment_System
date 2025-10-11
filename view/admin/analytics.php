<?php
session_start();
require_once("../../model/db.php");

if (!isset($_SESSION['userId']) || $_SESSION['RoleId'] != 2) {
    header("Location: ../login.php");
    exit;
}

$conn = getConnection();

/*getin all tasks r assigned users*/
$tasks = mysqli_query($conn, "
    SELECT 
        t.taskID,
        t.task_type,
        t.status,
        t.completion_rate,
        t.deadline,
        t.assigned_date,
        u.Name AS assigned_to
    FROM task t
    JOIN task_assignment ta ON t.taskID = ta.taskID
    JOIN user u ON ta.assigned_To = u.userId
    ORDER BY t.deadline ASC
");

/*resource requests that are approved getting fetched*/
$resources = mysqli_query($conn, "
    SELECT 
        r.Request_ID,
        r.Resource_Name,
        r.Resource_amount,
        r.status,
        u.Name AS requested_by
    FROM resource r
    JOIN user u ON r.Request_By = u.userId
    WHERE r.status = 'Approved'
    ORDER BY r.Request_ID DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Analytics</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #fafafa; }
        .header { background: #222; color: #fff; padding: 15px; border-radius: 10px; }
        .header a { color: #fff; text-decoration: none; margin-right: 15px; }
        h1, h2 { margin-bottom: 10px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; }
        th { background: #f4f4f4; }
        .progress-bar { height: 20px; background: #ddd; border-radius: 10px; overflow: hidden; }
        .progress { height: 20px; background: #28a745; color: #fff; text-align: center; font-size: 12px; }
        .section { margin-top: 40px; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 5px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="header">
    <h1>Admin Analytics Overview</h1>
    <a href="home.php">🏠 Home</a>
    <a href="../logout.php">🚪 Logout</a>
</div>

<!-- tasks sec -->
<div class="section">
    <h2>📊 Task Progress</h2>
    <table>
        <tr>
            <th>Task ID</th>
            <th>Task Type</th>
            <th>Assigned To</th>
            <th>Status</th>
            <th>Completion</th>
            <th>Deadline</th>
        </tr>
        <?php while ($task = mysqli_fetch_assoc($tasks)): ?>
        <tr>
            <td><?= $task['taskID'] ?></td>
            <td><?= htmlspecialchars($task['task_type']) ?></td>
            <td><?= htmlspecialchars($task['assigned_to']) ?></td>
            <td><?= htmlspecialchars($task['status']) ?></td>
            <td>
                <div class="progress-bar">
                    <div class="progress" style="width: <?= $task['completion_rate'] ?>%">
                        <?= $task['completion_rate'] ?>%
                    </div>
                </div>
            </td>
            <td><?= htmlspecialchars($task['deadline']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<!-- section for approved resource request -->
<div class="section">
    <h2>📦 Approved Resource Requests</h2>
    <table>
        <tr>
            <th>Request ID</th>
            <th>Resource Name</th>
            <th>Amount</th>
            <th>Requested By</th>
            <th>Status</th>
        </tr>
        <?php while ($res = mysqli_fetch_assoc($resources)): ?>
        <tr>
            <td><?= $res['Request_ID'] ?></td>
            <td><?= htmlspecialchars($res['Resource_Name']) ?></td>
            <td><?= htmlspecialchars($res['Resource_amount']) ?></td>
            <td><?= htmlspecialchars($res['requested_by']) ?></td>
            <td style="color: green; font-weight: bold;"><?= htmlspecialchars($res['status']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
