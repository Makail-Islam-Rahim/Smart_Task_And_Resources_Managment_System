<?php
require_once('db.php');

function getAllPerformanceReports() {
    $conn = getConnection();
    if (!$conn) return [];
    $sql = """SELECT 
    pr.Report_Id,
    pr.Report_Date,
    COALESCE(rt.task_completed, 0) AS task_completed,
    COALESCE(rr.resource_amount, 0) AS resource_amount,
    COALESCE(rr.resource_used, 0) AS resource_used
FROM performance_report pr
LEFT JOIN report_task rt ON pr.Report_Id = rt.Report_Id
LEFT JOIN report_resource rr ON pr.Report_Id = rr.Report_Id
ORDER BY pr.Report_Id DESC""";
    $res = mysqli_query($conn, $sql);
    $data = [];
    while ($r = mysqli_fetch_assoc($res)) $data[] = $r;
    mysqli_close($conn);
    return $data;
}

function generatePerformanceReport() {
    $conn = getConnection();
    if (!$conn) return false;
    
    $tasksDone = 0; $totalTasks = 0; $totalResources = 0; $usedResources = 0;
    $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS done FROM task WHERE status='Done'")); if ($r) $tasksDone = intval($r['done']);
    $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM task")); if ($r) $totalTasks = intval($r['total']);
    $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(Resource_amount),0) AS total FROM resource")); if ($r) $totalResources = intval($r['total']);
    $r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS used FROM resource WHERE status='Approved'")); if ($r) $usedResources = intval($r['used']);

  
    $stmt = mysqli_prepare($conn, "INSERT INTO performance_report (Report_Date) VALUES (CURDATE())");
    if (!$stmt) { mysqli_close($conn); return false; }
    mysqli_stmt_execute($stmt);
    $reportId = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare($conn, "INSERT INTO report_task (Report_Id, task_completed) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, 'ii', $reportId, $tasksDone);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

 
    $stmt = mysqli_prepare($conn, "INSERT INTO report_resource (Report_Id, resource_amount, resource_used) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'iii', $reportId, $totalResources, $usedResources);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    mysqli_close($conn);
    return true;
}

function updatePerformanceReport($id, $tasksCompleted, $resourceAmount, $resourceUsed) {
    $conn = getConnection();
    if (!$conn) return false;
    $id = intval($id);
    $tasksCompleted = intval($tasksCompleted);
    $resourceAmount = intval($resourceAmount);
    $resourceUsed = intval($resourceUsed);

    $stmt = mysqli_prepare($conn, "UPDATE report_task SET task_completed=? WHERE Report_Id=?");
    mysqli_stmt_bind_param($stmt, 'ii', $tasksCompleted, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare($conn, "UPDATE report_resource SET resource_amount=?, resource_used=? WHERE Report_Id=?");
    mysqli_stmt_bind_param($stmt, 'iii', $resourceAmount, $resourceUsed, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    mysqli_close($conn);
    return true;
}
?>