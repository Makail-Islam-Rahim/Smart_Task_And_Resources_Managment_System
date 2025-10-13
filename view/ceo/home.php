<?php
session_start();
    if (!isset($_SESSION['userId']) || $_SESSION['RoleId'] != 1) {
    header('Location: ../login.php');
    exit;
}
require_once('../../controller/userController.php');
$myTasks = fetchUserTasks($_SESSION['userId']);
$name=$_SESSION["Name"];
?>

<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/ceo_home_css.css">
    </head>
    <body>
    <div class="header" id="myHeader">
    <?php  echo "<h1>Welcome ".$name."</h1>" ?>
    <div class="side-menu">
        <ul>
            <li><?php echo "<a href='home.php'>Home</a>" ?></li>
            <li><?php echo "<a href='../logout.php'>logout</a>" ?></li>
        </ul>
    </div>
    </div>

    <div class="container">
        <div class="cards">
            <div class="card">
                <h2>Accounts</h2>
                <p>See All Active Accounts</p>
                <a href="accounts.php" class="btn">View Accounts</a>
            </div>

            <div class="card">
                <h2>Profile</h2>
                <p>Your personal information</p>
                <a href="profile.php" class="btn">View Profile</a>
            </div>

            <div class="card">
                <h2>Performance Report</h2>
                <p>All Performance</p>
                <a href="performance_report.php" class="btn">View Report</a>
            </div>

            <div class="card">
                <h2>Manage Users</h2>
                <p>View,update,Add Admin</p>
                <a href="manage_user.php" class="btn">Manage Users</a>
            </div>

            <div class="card">
                <h2>Logout</h2>
                <p>Sign out your account.</p>
                <a href="../logout.php" class="btn logout-btn">Logout</a>
            </div>
        </div>
    </div>
    
    </body>
</html>