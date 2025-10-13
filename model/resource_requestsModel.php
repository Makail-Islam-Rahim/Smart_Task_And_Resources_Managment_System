<?php
require_once('db.php');

function getManagerResourceRequests() {
    $conn = getConnection();
    if (!$conn) return [];

    $sql = "SELECT r.Request_ID, r.Resource_Name, r.Resource_amount, 
                   r.status, u.Name AS requested_by
            FROM resource r
            JOIN user u ON r.Request_By = u.userId
            ORDER BY r.Request_ID DESC";

    $result = mysqli_query($conn, $sql);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    mysqli_close($conn);
    return $data;
}

function addResourceRequest($resourceName, $amount, $requestedBy) {
    $conn = getConnection();
    if (!$conn) return false;

    $stmt = mysqli_prepare($conn, "INSERT INTO resource (Resource_Name, Resource_amount, Request_By, status) VALUES (?, ?, ?, 'Pending')");
    mysqli_stmt_bind_param($stmt, "sii", $resourceName, $amount, $requestedBy);
    $ok = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $ok;
}

function updateResourceStatus($requestId, $newStatus) {
    $conn = getConnection();
    if (!$conn) return false;

    $stmt = mysqli_prepare($conn, "UPDATE resource SET status=? WHERE Request_ID=?");
    mysqli_stmt_bind_param($stmt, "si", $newStatus, $requestId);
    $ok = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $ok;
}
?>
