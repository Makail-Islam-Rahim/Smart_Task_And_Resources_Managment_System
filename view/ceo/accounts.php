<?php
session_start();
require_once("../../controller/userController.php");

if (!isset($_SESSION["userId"]) || $_SESSION["RoleId"] != 1) {
    header("Location: ../login.php");
    exit;
}

$users = fetchAllUsers();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>All User Accounts</title>
    <link rel="stylesheet" href="../../css/style.css">
    <style>
        body { font-family: Arial; margin: 40px; }
        .header { background: #e3e3e3; padding: 15px; border-radius: 10px; }
        .side-menu ul { list-style: none; padding: 0; }
        .side-menu li { margin: 8px 0; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; }
        th { background: #f4f4f4; }
        a.button {
            background: #007BFF; color: white; padding: 6px 10px;
            border-radius: 5px; text-decoration: none;
        }
        a.button:hover { background: #0056b3; }
    </style>
</head>
<body>

<div class="header" id="myHeader">
    <h1>Welcome, CEO</h1>
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
