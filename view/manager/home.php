<?php
session_start();
    if (!isset($_SESSION['userId']) || $_SESSION['RoleId'] != 3) {
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
    </head>
    <body>
    <div class="header" id="myHeader">
    <?php  echo "<h1>Welcome ".$_SESSION["Name"]."</h1>" ?>
    <div class="side-menu">
        <ul>
            <li><?php echo "<a href='home.php'>Home</a>" ?></li>
            <li ><?php echo "<a href='profile.php'>Profile</a>" ?></li>
            <li>Resources</li>
            <li><?php echo "<a href='../logout.php'>logout</a>" ?></li>
        </ul>
    </div>
    
    <?php echo "<a href='../logout.php'>logout</a>" ?>
    </body>
</html>