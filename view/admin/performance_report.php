<?php
session_start();
require_once("../../model/db.php");

if (!isset($_SESSION['userId']) || $_SESSION['RoleId'] != 2) {
    header("Location: ../login.php");
    exit;
}

$conn = getConnection();
$message = "";


if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

   
    mysqli_query($conn, "DELETE FROM report_task WHERE Report_Id=$id");
    mysqli_query($conn, "DELETE FROM report_resource WHERE Report_Id=$id");
    mysqli_query($conn, "DELETE FROM performance_report WHERE Report_Id=$id");

    $message = "🗑️ Report #$id deleted successfully!";
}

if (isset($_POST['update_report'])) {
    $id = intval($_POST['report_id']);
    $tasksCompleted = intval($_POST['task_completed']);
    $resTotal = intval($_POST['resource_amount']);
    $resUsed = intval($_POST['resource_used']);

   
    mysqli_query($conn, "UPDATE report_task SET task_completed=$tasksCompleted WHERE Report_Id=$id");
    mysqli_query($conn, "UPDATE report_resource SET resource_amount=$resTotal, resource_used=$resUsed WHERE Report_Id=$id");

    $message = "✏️ Report #$id updated successfully!";
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

    $message = "✅ New performance report generated successfully!";
}

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
<link rel="stylesheet" href="../css/admincss/common.css">
<link rel="stylesheet" href="../css/admincss/performance_report.css">

    <meta charset="UTF-8">
    <title>Performance Reports</title>
    
</head>
<body>

<div class="header">
    <h1>Admin: Performance Reports</h1>
    <a href="home.php">🏠 Home</a>
    <a href="analytics.php">📊 Analytics</a>
    <a href="../logout.php">🚪 Logout</a>
</div>

<div class="section">
    <h2>📈 Generate New Performance Report</h2>
    <?php if ($message): ?><p class="message"><?= $message ?></p><?php endif; ?>
    <form method="POST">
        <button type="submit" name="generate_report" class="generate">Generate Report</button>
    </form>
</div>

<div class="section">
    <h2>🧾 Existing Reports</h2>
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
            <td>
                <!-- editing mini form tigger point -->
                <button onclick="openEdit(<?= $r['Report_Id'] ?>,
                                          <?= $r['task_completed'] ?? 0 ?>,
                                          <?= $r['resource_amount'] ?? 0 ?>,
                                          <?= $r['resource_used'] ?? 0 ?>)" 
                        class="btn edit">Edit</button>

                <!-- link delete -->
                <a href="?delete=<?= $r['Report_Id'] ?>" 
                   onclick="return confirm('Delete this report permanently?')" 
                   class="btn delete">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<!-- editing mini form -->
<div id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
    background:rgba(0,0,0,0.6); align-items:center; justify-content:center;">
    <form method="POST" style="background:white; padding:25px; border-radius:10px; width:350px;">
        <h3>Edit Report</h3>
        <input type="hidden" name="report_id" id="edit_report_id">
        <label>Tasks Completed:</label><br>
        <input type="number" name="task_completed" id="edit_task_completed" required><br><br>
        <label>Total Resources:</label><br>
        <input type="number" name="resource_amount" id="edit_resource_amount" required><br><br>
        <label>Resources Used:</label><br>
        <input type="number" name="resource_used" id="edit_resource_used" required><br><br>
        <button type="submit" name="update_report" class="btn generate">Save Changes</button>
        <button type="button" onclick="closeEdit()" class="btn delete">Cancel</button>
    </form>
</div>

<script>
function openEdit(id, tasks, total, used) {
    document.getElementById("edit_report_id").value = id;
    document.getElementById("edit_task_completed").value = tasks;
    document.getElementById("edit_resource_amount").value = total;
    document.getElementById("edit_resource_used").value = used;
    document.getElementById("editModal").style.display = "flex";
}
function closeEdit() {
    document.getElementById("editModal").style.display = "none";
}
</script>

</body>
</html>
