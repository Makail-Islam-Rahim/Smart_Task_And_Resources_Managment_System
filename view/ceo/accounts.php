<?php
session_start();
require_once("../../controller/userController.php");

if (!isset($_SESSION["userId"]) || $_SESSION["RoleId"] != 1) {
    header("Location: ../login.php");
    exit;
}

$users = fetchAllUsers();
$counts = getUserRoleCounts();
$name=$_SESSION["Name"]
?>

<!DOCTYPE html>
<html>
<head>
    <title>All User Accounts</title>
    <link rel="stylesheet" href="../css/ceo_accounts_style.css">
</head>
<body>

 <div class="header" id="myHeader">
    <?php  echo "<h1>Welcome ".$name."</h1>" ?>
    <div class="side-menu">
        <ul>
            <li><?php echo "<a href='home.php'>Home</a>" ?></li>
            <li><?php echo "<a href='profile.php'>Profile</a>" ?></li>    
             <li><?php echo "<a href='accounts.php'>Accounts</a>" ?></li>
            <li><?php echo "<a href='performance_report.php'>Performance</a>" ?></li>
            <li><?php echo "<a href='../logout.php'>logout</a>" ?></li>
        </ul>
    </div>
    </div>


    <div class="container">
        <h1>User Role Summary</h1>

        <div class="cards">
            <div class="card">
                <h2>Total Admins</h2>
                <p><?= $counts['Admin'] ?></p>
            </div>
            <div class="card">
                <h2>Total Managers</h2>
                <p><?= $counts['Manager'] ?></p>
            </div>
            <div class="card">
                <h2>Total Employees</h2>
                <p><?= $counts['Employee'] ?></p>
            </div>
            <div class="card">
                <h2>Total Users</h2>
                <p><?= $counts['Total'] ?></p>
            </div>
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
    </tr>

    <?php foreach ($users as $u): ?>
        <tr>
            <td><?= $u['userId'] ?></td>
            <td><?= $u['Name'] ?></td>
            <td><?= $u['Email'] ?></td>
            <td><?= $u['RoleId'] ?></td>
            <td><?= $u['Age'] ?></td>
            <td><?= $u['Gender'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
