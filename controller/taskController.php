<?php
require_once(__DIR__ . '/../model/db.php');

function getTasksByUser($userId) {
    $conn = getConnection();
    $sql = "SELECT t.taskID, t.task_type, t.status, t.completion_rate, t.deadline
            FROM task t
            JOIN task_assignment ta ON t.taskID = ta.taskID
            WHERE ta.assigned_To = $userId";

    $result = mysqli_query($conn, $sql);
    $tasks = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $tasks[] = $row;
        }
    }
    return $tasks;
}

function countTasksByStatus($userId, $status) {
    $conn = getConnection();
    $sql = "SELECT COUNT(*) AS count
            FROM task t
            JOIN task_assignment ta ON t.taskID = ta.taskID
            WHERE ta.assigned_To = $userId AND t.status = '$status'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] ?? 0;
}

function countTotalTasks($userId) {
    $conn = getConnection();
    $sql = "SELECT COUNT(*) AS count
            FROM task t
            JOIN task_assignment ta ON t.taskID = ta.taskID
            WHERE ta.assigned_To = $userId";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] ?? 0;
}
