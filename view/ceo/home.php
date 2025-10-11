<?php
session_start();
    if (!isset($_SESSION['userId']) || $_SESSION['RoleId'] != 4) {
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

    </div>
    <h2>Your Assigned Tasks</h2>
    <?php if($myTasks && is_array($myTasks)): ?>
        <table border="1">
            <tr><th>ID</th><th>Type</th><th>Status</th><th>Deadline</th><th>Completion</th></tr>
            <?php foreach($myTasks as $t): ?>
                <tr>
                    <td><?php echo htmlspecialchars($t['taskID']); ?></td>
                    <td><?php echo htmlspecialchars($t['task_type']); ?></td>
                    <td><?php echo htmlspecialchars($t['status']); ?></td>
                    <td><?php echo htmlspecialchars($t['deadline']); ?></td>
                    <td><?php echo htmlspecialchars($t['completion_rate']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
            <p>No tasks assigned to you.</p>
        <?php endif; ?>
    

    <?php echo "<a href='../logout.php'>logout</a>" ?>
    </body>
</html>