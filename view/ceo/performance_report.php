<?php
session_start();
require_once("../../controller/authController.php");
require_once("../../controller/userController.php");
require_once("../../controller/performanceController.php");



$conn = getConnection();

if (isset($_POST["generate_report"])) {
    $message = generatePerformanceReport($conn);
}

$reports = fetchPerformanceReports($conn);

?>
<!DOCTYPE html>
<head>
    <title>CEO Performance Reports</title>
    <link rel="stylesheet" href="../css/ceo_performanse_style.css">
</head>
<body>
<div class="header">
    <h1>CEO: Performance Reports</h1>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="accounts.php">Accounts</a></li>
        <li><a href="analytics.php">Analytics</a></li>
        <li><a href="performance_report.php">Performance</a></li>
        <li><a href="../logout.php">Logout</a></li>
    </ul>
</div>

<?php if (!empty($message)): ?>
    <div class="section">
        <p style="color:green; font-weight:bold;"><?= htmlspecialchars($message) ?></p>
    </div>
<?php endif; ?>

<div class="section">
    <h2>Generate New Performance Report</h2>
    <form method="POST">
        <button type="submit" name="generate_report" class="generate">Generate Report</button>
    </form>
</div>

<div class="section">
    <h2>Existing Reports</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Tasks Completed</th>
            <th>Total Resources</th>
            <th>Resources Approved</th>
            <th>Progress</th>
        </tr>
        <?php while ($r = mysqli_fetch_assoc($reports)):
            $totalTasks = max(mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM task"))['total'], 1);
            $taskRatio = ($r['task_completed'] ?? 0) / $totalTasks;
            $resRatio = ($r['resource_used'] ?? 0) / max(($r['resource_amount'] ?? 1), 1);
            $progress = round((($taskRatio + $resRatio) / 2) * 100, 2);
        ?>
        <tr>
            <td><?= $r['Report_Id'] ?></td>
            <td><?= htmlspecialchars($r['Report_Date']) ?></td>
            <td><?= htmlspecialchars($r['task_completed']) ?></td>
            <td><?= htmlspecialchars($r['resource_amount']) ?></td>
            <td><?= htmlspecialchars($r['resource_used']) ?></td>
            <td>
                <div class="progress-bar">
                    <div class="progress" style="width: <?= $progress ?>%">
                        <?= $progress ?>%
                    </div>
                </div>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
