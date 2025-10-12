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
    
    $email=$_SESSION["email"];
    $age=$_SESSION["age"];
    $name=$_SESSION["Name"];
?>



<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="../css/ceo_profile_style.css">
    </head>
    <body>
    <div class="header" id="myHeader">
    <?php  echo "<h1>Welcome ".$name."</h1>" ?>
    <div class="side-menu">
        <ul>
            <li><?php echo "<a href='home.php'>Home</a>" ?></li>
            <li><?php echo "<a href='profile.php'>Profile</a>" ?></li>    
            <li><?php echo "<a href='resource.php'>Resources</a>"?></li>
            <li><?php echo "<a href='../logout.php'>logout</a>" ?></li>
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