<?php
session_start();
require_once("../../model/db.php");

$conn=getConnection();

if (!isset($_SESSION['userId']) || $_SESSION['RoleId'] != 1) {
    header("Location: ../login.php");
    exit;
}
if (isset($_POST["generate_report"])) {
    $tasksDone = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS done FROM task WHERE status='Done'"))["done"];
    $totalTasks = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM task"))["total"];
    $totalResources = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(Resource_amount) AS total FROM resource"))["total"];
    $usedResources = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS used FROM resource WHERE status='Approved'"))["used"];

    mysqli_query($conn, "INSERT INTO performance_report (Report_Date) VALUES (CURDATE())");
    $reportId = mysqli_insert_id($conn);

    mysqli_query($conn, "INSERT INTO report_task (Report_Id, task_completed) VALUES ($reportId, $tasksDone)");
    mysqli_query($conn, "INSERT INTO report_resource (Report_Id, resource_amount, resource_used)
                         VALUES ($reportId, $totalResources, $usedResources)");

    $message = " New performance report generated successfully!";
}

/*reports fetching*/
$sql = "
SELECT 
    pr.Report_Id,
    pr.Report_Date,
    rt.task_completed,
    rr.resource_amount,
    rr.resource_used
FROM performance_report pr
LEFT JOIN report_task rt ON pr.Report_Id = rt.Report_Id
LEFT JOIN report_resource rr ON pr.Report_Id = rr.Report_Id
ORDER BY pr.Report_Id DESC";

$reports = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Performance Reports</title>
    <link rel="stylesheet" href="../css/style.css">
   
</head>
<body>

<div class="header">
    <h1>CEO: Performance Reports</h1>
    li><?php echo "<a href='home.php'>Home</a>" ?></li>
            <li ><?php echo "<a href='profile.php'>Profile</a>" ?></li>
            <li><?php echo "<a href='accounts.php'>Accounts</a>" ?></li>
            <li><?php echo "<a href='analytics.php'>Analytics</a>" ?></li>
             <li><?php echo "<a href='performance_report.php'>Performance</a>" ?></li>
            <li><?php echo "<a href='../logout.php'>logout</a>" ?></li>
</div>

<div class="section">
    <h2> Generate New Performance Report</h2>
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
            <th>Action</th>
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
