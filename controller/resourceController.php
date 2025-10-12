<?php
require_once(__DIR__ . "/../model/db.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request_resource'])) {
    $conn = getConnection();

    $resource_name = trim($_POST['resource_name']);
    $resource_amount = intval($_POST['resource_amount']);
    $request_by = $_SESSION['userId'];
    $status = 'pending';

    $result = mysqli_query($conn, "SELECT userId FROM user WHERE RoleId = 3 LIMIT 1");
    $row = mysqli_fetch_assoc($result);
    $request_to = $row['userId'];

    $sql = "INSERT INTO resource (resource_name, status, resource_amount, request_by, request_to)
            VALUES ('$resource_name', '$status', '$resource_amount', '$request_by', '$request_to')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success_message'] = "Resource request submitted successfully!";
        header("Location: ../view/employee/resource.php");  
        exit();
    } else {
        error_log("SQL Error: " . mysqli_error($conn));  
    }
}

function getUserRequestsCount($userId, $status = null) {
    $conn = getConnection();

    if ($status != null) {
        $sql = "SELECT COUNT(*) as count FROM resource WHERE request_by = $userId AND status = '$status'";
    } else {
        $sql = "SELECT COUNT(*) as count FROM resource WHERE request_by = $userId";
    }

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}
?>
