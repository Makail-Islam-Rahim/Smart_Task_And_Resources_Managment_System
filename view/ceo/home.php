<?php
session_start();
    if (!isset($_SESSION['userId']) || $_SESSION['RoleId'] != 1) {
    header('Location: ../login.php');
    exit;
}
require_once('../../controller/userController.php');
$myTasks = fetchUserTasks($_SESSION['userId']);

?>

<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/ceo_home_css.css">
    </head>
    <body>
    <div class="header" id="myHeader">
    <?php  echo "<h1>Welcome ".$_SESSION["Name"]."</h1>" ?>
    <div class="side-menu">
        <ul>
            <li><?php echo "<a href='home.php'>Home</a>" ?></li>
            <li ><?php echo "<a href='profile.php'>Profile</a>" ?></li>
            <li><?php echo "<a href='accounts.php'>Accounts</a>" ?></li>
            <li><?php echo "<a href='analytics.php'>Analytics</a>" ?></li>
            <li><?php echo "<a href='performance_report.php'>Rerformance</a>" ?></li>
            <li><?php echo "<a href='../logout.php'>logout</a>" ?></li>
        </ul>
    </div>
    </div>

    <div class="container">
        <div class="cards">
            <div class="card">
                <h2>Accounts</h2>
                <p>Manage company accounts and financial summaries.</p>
                <a href="accounts.php" class="btn">View Accounts</a>
            </div>

            <div class="card">
                <h2>Profile</h2>
                <p>Update your personal information and settings.</p>
                <a href="profile.php" class="btn">View Profile</a>
            </div>

            <div class="card">
                <h2>Performance Report</h2>
                <p>Analyze performance and track department progress.</p>
                <a href="performance_report.php" class="btn">View Report</a>
            </div>

            <div class="card">
                <h2>Manage Users</h2>
                <p>View, add, or delete users.</p>
                <a href="manage_user.php" class="btn">Manage Users</a>
            </div>

            <div class="card">
                <h2>Manage Resources</h2>
                <p>Approve or track resource requests.</p>
                <a href="../resource/manage_resources.php" class="btn">View Resources</a>
            </div>

            <div class="card">
                <h2>View Reports</h2>
                <p>Check task progress and summaries.</p>
                <a href="../report/reports.php" class="btn">View Reports</a>
            </div>

            <div class="card">
                <h2>Logout</h2>
                <p>Sign out of your CEO account.</p>
                <a href="../../logout.php" class="btn logout-btn">Logout</a>
            </div>
        </div>
    </div>
    
    <?php echo "<a href='../logout.php'>logout</a>" ?>
    </body>
</html>