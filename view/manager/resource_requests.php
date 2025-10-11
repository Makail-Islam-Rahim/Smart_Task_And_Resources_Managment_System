<?php
session_start();
require_once("../../controller/userController.php");
require_once("../../model/db.php");

if (!isset($_SESSION['userId']) || $_SESSION['RoleId'] != 3) {
    header("Location: ../login.php");
    exit;
}

$conn = getConnection();

// ekhane Approve/Reject actions
if (isset($_GET["approve"])) {
    $id = intval($_GET["approve"]);
    mysqli_query($conn, "UPDATE resource SET status='Approved' WHERE Request_ID=$id");
}
if (isset($_GET["reject"])) {
    $id = intval($_GET["reject"]);
    mysqli_query($conn, "UPDATE resource SET status='Rejected' WHERE Request_ID=$id");
}

// all resource requests sent to this manager
$sql = "SELECT r.Request_ID, r.Resource_Name, r.status, r.Resource_amount,
               u.Name AS requested_by
        FROM resource r
        JOIN user u ON r.Request_By = u.userId
        WHERE r.Request_To = " . $_SESSION['userId'];

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Resource Requests</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        a.btn { padding: 5px 10px; text-decoration: none; border-radius: 5px; }
        .approve { background: #28a745; color: white; }
        .reject { background: #dc3545; color: white; }
        a.btn:hover { opacity: 0.8; }
    </style>
</head>
<body>
<h1>Resource Requests</h1>
<a href="home.php">← Back to Home</a>

<table>
    <tr>
        <th>ID</th>
        <th>Resource</th>
        <th>Amount</th>
        <th>Requested By</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['Request_ID'] ?></td>
            <td><?= htmlspecialchars($row['Resource_Name']) ?></td>
            <td><?= htmlspecialchars($row['Resource_amount']) ?></td>
            <td><?= htmlspecialchars($row['requested_by']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td>
                <?php if ($row['status'] == 'Pending'): ?>
                    <a href="?approve=<?= $row['Request_ID'] ?>" class="btn approve">Approve</a>
                    <a href="?reject=<?= $row['Request_ID'] ?>" class="btn reject">Reject</a>
                <?php else: ?>
                    <?= htmlspecialchars($row['status']) ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
