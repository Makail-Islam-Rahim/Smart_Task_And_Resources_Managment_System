<?php
session_start();
require_once(__DIR__ . '/../model/db.php');
require_once(__DIR__ . '/../model/performance_reportModel.php');

if (!isset($_SESSION['userId']) || $_SESSION['RoleId'] != 2) { header('Location: ../login.php'); exit; }

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['generate_report'])) {
        if (generatePerformanceReport()) {
            $message = '✅ New performance report generated successfully!';
        } else {
            $message = '⚠️ Failed to generate report.';
        }
    } elseif (isset($_POST['update_report'])) {
        $id = intval($_POST['report_id'] ?? 0);
        $tasksCompleted = intval($_POST['task_completed'] ?? 0);
        $resTotal = intval($_POST['resource_amount'] ?? 0);
        $resUsed = intval($_POST['resource_used'] ?? 0);
        if (updatePerformanceReport($id, $tasksCompleted, $resTotal, $resUsed)) {
            $message = "✏️ Report #$id updated successfully!";
        } else {
            $message = '⚠️ Failed to update report.';
        }
    }
}


$reports = getAllPerformanceReports();

include(__DIR__ . '/../view/admin/performance_report.php');
?>