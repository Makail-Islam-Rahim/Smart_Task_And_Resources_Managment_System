<?php
session_start();
require_once("../../controller/userController.php");

if (!isset($_SESSION["userId"]) || $_SESSION["RoleId"] != 2) {
    header("Location: ../login.php");
    exit;
}

$users = fetchAllUsers();
?>

<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="../css/admincss/common.css">

    <meta charset="utf-8">
    <title>All User Accounts</title>
    
    
</head>
<body>

<div class="header" id="myHeader">
    <h1>Welcome, Admin</h1>
    <div class="side-menu">
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="accounts.php">Accounts</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
</div>

<h2>All Registered Users</h2>
<table>
    <tr>
        <th>User ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Action</th>
    </tr>

    <?php foreach ($users as $u): ?>
        <tr>
            <td><?= htmlspecialchars($u['userId']) ?></td>
            <td><?= htmlspecialchars($u['Name']) ?></td>
            <td><?= htmlspecialchars($u['Email']) ?></td>
            <td><?= htmlspecialchars($u['RoleId']) ?></td>
            <td><?= htmlspecialchars($u['Age']) ?></td>
            <td><?= htmlspecialchars($u['Gender']) ?></td>
            <td><a class="button" href="view_user.php?id=<?= $u['userId'] ?>">View</a></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
