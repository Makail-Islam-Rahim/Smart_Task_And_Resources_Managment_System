<?php
session_start();
require_once(__DIR__ . '/../model/db.php');
require_once(__DIR__ . '/../model/analyticsModel.php');

if (!isset($_SESSION['userId']) || $_SESSION['RoleId'] != 2) {
    header("Location: ../login.php");
    exit;
}

$tasks = getAnalyticsTasks();
$resources = getAnalyticsResources();

include(__DIR__ . '/../view/admin/analytics.php');
?>