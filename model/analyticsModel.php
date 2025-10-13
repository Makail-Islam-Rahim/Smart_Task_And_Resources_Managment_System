<?php
require_once('db.php');

function getAnalyticsTasks() {
    $conn = getConnection();
    $sql = "SELECT t.taskID, t.task_type, t.status, t.completion_rate, t.deadline, 
                   t.assigned_date, u.Name AS assigned_to
            FROM task t
            JOIN task_assignment ta ON t.taskID = ta.taskID
            JOIN user u ON ta.assigned_To = u.userId
            ORDER BY t.deadline ASC";
    $result = mysqli_query($conn, $sql);
    $tasks = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $tasks[] = $row;
    }
    mysqli_close($conn);
    return $tasks;
}

function getAnalyticsResources() {
    $conn = getConnection();
    $sql = "SELECT r.Request_ID, r.Resource_Name, r.Resource_amount, r.status, 
                   u.Name AS requested_by
            FROM resource r
            JOIN user u ON r.Request_By = u.userId
            WHERE r.status = 'Approved'
            ORDER BY r.Request_ID DESC";
    $result = mysqli_query($conn, $sql);
    $resources = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $resources[] = $row;
    }
    mysqli_close($conn);
    return $resources;
}
?>