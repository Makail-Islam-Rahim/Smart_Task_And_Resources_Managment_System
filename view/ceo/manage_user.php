<?php
session_start();
require_once("../../controller/userController.php");

if (!isset($_SESSION["userId"]) || $_SESSION["RoleId"] != 1) {
    header("Location: ../login.php");
    exit;
}

$users = fetchAllUsers();


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>All User Accounts</title>
   <link rel="stylesheet" href="../css/ceo_user_manage.css">
    
</head>
<body>

<div class="header" id="myHeader">
    <h1>Welcome, CEO</h1>
    <div class="side-menu">
        <ul>
           <li><?php echo "<a href='home.php'>Home</a>" ?></li>
            <li ><?php echo "<a href='profile.php'>Profile</a>" ?></li>
            <li><?php echo "<a href='accounts.php'>Accounts</a>" ?></li>
            <li><?php echo "<a href='analytics.php'>Analytics</a>" ?></li>
            <li><?php echo "<a href='performance_report.php'>Performance</a>" ?></li>
            <li><?php echo "<a href='../logout.php'>logout</a>" ?></li>
        </ul>
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
        <th>Action</th>
    </tr>

    <?php foreach ($users as $u): ?>
        <tr>
            <td><?= htmlspecialchars($u['userId']) ?></td>
            <td><?= htmlspecialchars($u['Name']) ?></td>
            <td><?= htmlspecialchars($u['Email']) ?></td>
            <td><?= htmlspecialchars($u['RoleId']) ?></td>
            <td><?= htmlspecialchars($u['Age']) ?></td>
            <td><?= htmlspecialchars($u['Gender']) ?></td>
            <td><a class="button" href="ceo_view_user.php?id=<?= $u['userId'] ?>">View</a>
        </td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Add New User</h2>
<?php
if(isset($_GET['success'])){
    echo "<p style='color:green'>User added successfully!</p>";
}
if(isset($_GET['error']) && $_GET['error'] == 'email'){
    echo "<p style='color:red'>This email is already registered.</p>";
}
?>
<form action="../../controller/authController.php" method="post">
    <label>Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Role:</label><br>
    <select name="roleId" required>
        <option value="3">Admin</option>
    </select><br><br>

    <label>Age:</label><br>
    <input type="number" name="age" min="18" required><br><br>

    <label>Gender:</label><br>
    <select name="gender" required>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select><br><br>

    <button type="submit" name="add_user">Add Admin</button>
    <script>
    var existingEmails = [
        <?php foreach($users as $u) { echo "'". $u['Email'] ."',"; } ?>
    ];
</script>
</form>
<script src="../js/validateAddUser.js"></script>
</body>
</html>
