<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['RoleId'] != 4) {
    header("Location: ../login.php");
    exit;
}

require_once('../../controller/taskController.php');

$userId = $_SESSION['userId'];
$myTasks = getTasksByUser($userId);

$completed = countTasksByStatus($userId, 'Completed');
$pending = countTasksByStatus($userId, 'Pending');
$inProgress = countTasksByStatus($userId, 'In Progress');
$total = countTotalTasks($userId);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="../css/employee_home_style.css">
</head>
<body>
<div class="header">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['Name']); ?></h1>
    <div class="side-menu">
        <ul>
            <li><a href="home.php" >Home</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="resource.php">Resources</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
</div>

<div class="dashboard">
    <h2>Task Summary</h2>
    <div class="stats-container">
        <div class="card total">
            <h3><?php echo $total; ?></h3>
            <p>Total Tasks</p>
        </div>
        <div class="card completed">
            <h3><?php echo $completed; ?></h3>
            <p>Completed</p>
        </div>
        <div class="card pending">
            <h3><?php echo $pending; ?></h3>
            <p>Pending</p>
        </div>
        <div class="card progress">
            <h3><?php echo $inProgress; ?></h3>
            <p>In Progress</p>
        </div>
    </div>

    <h2 style="margin-top:40px;">Your Tasks</h2>
    <?php if ($myTasks && count($myTasks) > 0) { ?>
        <div class="task-container">
            <?php foreach ($myTasks as $t) { ?>
                <div class="task-card">
                    <h3><?php echo htmlspecialchars($t['task_type']); ?></h3>
                    <p>Status: <?php echo htmlspecialchars($t['status']); ?></p>
                    <p>Deadline: <?php echo htmlspecialchars($t['deadline']); ?></p>
                    <p class="completion">Completion: <?php echo htmlspecialchars($t['completion_rate']); ?>%</p>
                    <div class="progress-bar">
                        <div class="fill" style="width:<?php echo htmlspecialchars($t['completion_rate']); ?>%;"></div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p class="no-tasks">No tasks assigned to you yet.</p>
    <?php } ?>
</div>
</body>
</html>
