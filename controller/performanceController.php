<?php
require_once("../../model/db.php");
$conn = getConnection();

function generatePerformanceReport($conn) {
    $tasksDone = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS done FROM task WHERE status='Done'"))["done"];
    $totalTasks = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM task"))["total"];
    $totalResources = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(Resource_amount) AS total FROM resource"))["total"];
    $usedResources = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS used FROM resource WHERE status='Approved'"))["used"];

    mysqli_query($conn, "INSERT INTO performance_report (Report_Date) VALUES (CURDATE())");
    $reportId = mysqli_insert_id($conn);

    mysqli_query($conn, "INSERT INTO report_task (Report_Id, task_completed) VALUES ($reportId, $tasksDone)");
    mysqli_query($conn, "INSERT INTO report_resource (Report_Id, resource_amount, resource_used)
                         VALUES ($reportId, $totalResources, $usedResources)");

    return "New performance report generated successfully!";
}

function fetchPerformanceReports($conn) {
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
    return mysqli_query($conn, $sql);
}
?>
