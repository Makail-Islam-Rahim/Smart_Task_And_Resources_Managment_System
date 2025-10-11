<?php
session_start();
require_once("../../controller/userController.php");

if (!isset($_SESSION["userId"])) {
    header("Location: ../login.php");
    exit;
}

$userId = $_SESSION["userId"];
$user = fetchUserDataById($userId);

if (!$user) {
    echo "<h3>User not found.</h3>";
    exit;
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .header { background: #e3e3e3; padding: 15px; border-radius: 10px; }
        .side-menu ul { list-style: none; padding: 0; }
        .side-menu li { margin: 8px 0; }
        table { border-collapse: collapse; width: 60%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; }
        th { background: #f4f4f4; text-align: left; }
    </style>
</head>
<body>

<div class="header" id="myHeader">
    <h1>Welcome, <?= htmlspecialchars($user['Name']) ?>!</h1>
    <div class="side-menu">
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="profile.php">Profile</a></li>    
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
</div>

<h2>Your Information</h2>
<table>
    <tr><th>User ID</th><td><?= htmlspecialchars($user['userId']) ?></td></tr>
    <tr><th>Name</th><td><?= htmlspecialchars($user['Name']) ?></td></tr>
    <tr><th>Email</th><td><?= htmlspecialchars($user['Email']) ?></td></tr>
    <tr><th>Role ID</th><td><?= htmlspecialchars($user['RoleId']) ?></td></tr>
    <tr><th>Age</th><td><?= htmlspecialchars($user['Age']) ?></td></tr>
    <tr><th>Gender</th><td><?= htmlspecialchars($user['Gender']) ?></td></tr>
</table>

</body>
</html>
