<?php
session_start();
require_once("../../model/db.php");
require_once("../../model/analyticsModel.php");

if (!isset($_SESSION['userId']) || $_SESSION['RoleId'] != 2) {
    header("Location: ../login.php");
    exit;
}


if (!isset($tasks)) {
    $tasks = getAnalyticsTasks();
}
if (!isset($resources)) {
    $resources = getAnalyticsResources();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Analytics</title>
    <link rel="stylesheet" href="../css/admincss/common.css">
    <link rel="stylesheet" href="../css/admincss/analytics.css">
</head>
<body>
<div class="header">
    <h1>Admin Analytics Overview</h1>
    <a href="home.php">🏠 Home</a>
    <a href="../logout.php">🚪 Logout</a>
</div>

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
        <?php if (!empty($tasks)): ?>
            <?php foreach ($tasks as $item): ?>
            <tr>
                <td><?= $item['taskID'] ?></td>
                <td><?= htmlspecialchars($item['task_type']) ?></td>
                <td><?= htmlspecialchars($item['assigned_to']) ?></td>
                <td><?= htmlspecialchars($item['status']) ?></td>
                <td>
                    <div class="progress-bar">
                        <div class="progress" style="width: <?= $item['completion_rate'] ?>%">
                            <?= $item['completion_rate'] ?>%
                        </div>
                    </div>
                </td>
                <td><?= htmlspecialchars($item['deadline']) ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6">No tasks found.</td></tr>
        <?php endif; ?>
    </table>
</div>

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
        <?php if (!empty($resources)): ?>
            <?php foreach ($resources as $res): ?>
            <tr>
                <td><?= $res['Request_ID'] ?></td>
                <td><?= htmlspecialchars($res['Resource_Name']) ?></td>
                <td><?= htmlspecialchars($res['Resource_amount']) ?></td>
                <td><?= htmlspecialchars($res['requested_by']) ?></td>
                <td style="color: green; font-weight: bold;"><?= htmlspecialchars($res['status']) ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">No approved resources found.</td></tr>
        <?php endif; ?>
    </table>
</div>
</body>
</html>
