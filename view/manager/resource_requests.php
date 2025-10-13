<?php
session_start();
require_once("../../model/db.php");

// Only managers can access this page
if (!isset($_SESSION['userId']) || $_SESSION['RoleId'] != 3) {
    header("Location: ../login.php");
    exit;
}

// Include model if exists
require_once("../../model/resource_requestsModel.php");

// If model isn’t loaded or variables missing, fetch directly (fallback)
if (!function_exists('getManagerResourceRequests')) {
    function getManagerResourceRequests() {
        $conn = getConnection();
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
}

// Fetch requests
$requests = getManagerResourceRequests();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manager Resource Requests</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/manager/common.css">
</head>
<body>

<nav class="navbar">
  <div class="nav-left"><h2>Smart Task Manager</h2></div>
  <div class="nav-right">
    <a href="home.php">Home</a>
    <a href="profile.php">Profile</a>
    <a href="../logout.php">Logout</a>
  </div>
</nav>

<div class="section">
    <h2>📦 Resource Requests</h2>

    <table class="table">
        <tr>
            <th>Request ID</th>
            <th>Resource Name</th>
            <th>Amount</th>
            <th>Requested By</th>
            <th>Status</th>
        </tr>
        <?php if (!empty($requests)): ?>
            <?php foreach ($requests as $req): ?>
            <tr>
                <td><?= $req['Request_ID'] ?></td>
                <td><?= htmlspecialchars($req['Resource_Name']) ?></td>
                <td><?= htmlspecialchars($req['Resource_amount']) ?></td>
                <td><?= htmlspecialchars($req['requested_by']) ?></td>
                <td class="<?= $req['status'] == 'Approved' ? 'text-success' : '' ?>">
                    <?= htmlspecialchars($req['status']) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">No resource requests found.</td></tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
