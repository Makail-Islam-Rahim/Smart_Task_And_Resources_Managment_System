<?php
session_start();
require_once("../../model/db.php");
require_once("../../model/resource_requestsModel.php");

if (!isset($_SESSION['userId']) || $_SESSION['RoleId'] != 3) {
    header("Location: ../login.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'], $_POST['action'])) {
    $requestId = intval($_POST['request_id']);
    $action = $_POST['action'] === 'approve' ? 'Approved' : 'Rejected';
    updateResourceStatus($requestId, $action);
    header("Location: resource_requests.php");
    exit;
}


$requests = getManagerResourceRequests();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manager Resource Requests</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/manager/common.css">
    <style>
        .btn-danger {
            background: #ef4444;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
        }
        .btn-danger:hover {
            background: #dc2626;
        }
        form {
            display: inline;
        }
    </style>
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
            <th>Action</th>
        </tr>
        <?php if (!empty($requests)): ?>
            <?php foreach ($requests as $req): ?>
            <tr>
                <td><?= $req['Request_ID'] ?></td>
                <td><?= htmlspecialchars($req['Resource_Name']) ?></td>
                <td><?= htmlspecialchars($req['Resource_amount']) ?></td>
                <td><?= htmlspecialchars($req['requested_by']) ?></td>
                <td class="<?= $req['status'] == 'Approved' ? 'text-success' : ($req['status'] == 'Rejected' ? 'text-danger' : '') ?>">
                    <?= htmlspecialchars($req['status']) ?>
                </td>
                <td>
                    <?php if ($req['status'] == 'Pending'): ?>
                        <form method="post" action="">
                            <input type="hidden" name="request_id" value="<?= $req['Request_ID'] ?>">
                            <button type="submit" name="action" value="approve" class="btn">Approve</button>
                            <button type="submit" name="action" value="reject" class="btn-danger">Reject</button>
                        </form>
                    <?php else: ?>
                        <span class="text-muted">No action</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6">No resource requests found.</td></tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
