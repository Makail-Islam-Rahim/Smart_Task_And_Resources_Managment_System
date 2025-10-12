<?php

require_once('../../controller/authcontroller.php');
require_once('../../controller/usercontroller.php');
require_once('../../controller/resourcecontroller.php');

$userId = $_SESSION['userId'];
$userName = $_SESSION['Name'];

$totalRequests = getUserRequestsCount($userId);
$acceptedRequests = getUserRequestsCount($userId, 'accepted');
$pendingRequests = getUserRequestsCount($userId, 'pending');
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/employee_resourse_style.css">
    <title>Resource Dashboard</title>
</head>
<body>
<div class="header">
    <h1>Welcome, <?php echo htmlspecialchars($userName); ?></h1>
    <div class="side-menu">
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="resource.php">Resources</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>
    </div>
</div>

<div class="container">
    <div class="cards">
        <div class="card">
            <h3>Total Requests</h3>
            <p><?php echo $totalRequests; ?></p>
        </div>
        <div class="card accepted">
            <h3>Accepted</h3>
            <p><?php echo $acceptedRequests; ?></p>
        </div>
        <div class="card pending">
            <h3>Pending</h3>
            <p><?php echo $pendingRequests; ?></p>
        </div>
    </div>
    </div>
 <div class="container">
    <h2>Request a Resource</h2>
    <form method="post" action="../../controller/resourceController.php">
        <label>Resource Name:</label><br>
        <input type="text" name="resource_name" required><br><br>

        <label>Resourse Amount:</label><br>
        <input type="number" name="resource_amount" min="1" value="1" required><br><br>

        <label>Request To:</label><br>
        <textarea name="reason" rows="3"></textarea><br><br>

        <button type="submit" name="request_resource">Submit Request</button>
    </form>
</div>
    

</body>
</html>
