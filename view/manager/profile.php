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
    
<link rel="stylesheet" href="../css/managercss/common.css">
<link rel="stylesheet" href="../css/managercss/profile.css">
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