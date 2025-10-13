<?php
session_start();
require_once("../../controller/userController.php");

if (!isset($_SESSION["userId"]) || $_SESSION["RoleId"] != 1) {
    header("Location: ../login.php");
    exit;
}

$users = fetchAllUsers();
$name=$_SESSION["Name"]
?>

<!DOCTYPE html>
<html>
<head>
    <title>All User Accounts</title>
    <link rel="stylesheet" href="../css/ceo_user_manage.css">
</head>
<body>

<div class="header" id="myHeader">
     <?php  echo "<h1>Welcome ".$name."</h1>" ?>
    <div class="side-menu">
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="accounts.php">Accounts</a></li>
            <li><a href="performance_report.php">Performance</a></li>
            <li><a href="../logout.php">Logout</a></li>
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
        <td><?= $u['userId'] ?></td>
        <td><?= $u['Name'] ?></td>
        <td><?= $u['Email'] ?></td>
        <td><?= $u['RoleId'] ?></td>
        <td><?= $u['Age'] ?></td>
        <td><?= $u['Gender'] ?></td>
        <td><a class="button" href="ceo_view_user.php?id=<?= $u['userId'] ?>">View</a></td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>Add Admin</h2>

<?php
if (isset($_GET['success'])) {
    echo "<p style='color:green'>User added successfully!</p>";
}
if (isset($_GET['error']) && $_GET['error'] == 'email') {
    echo "<p style='color:red'>This email is already registered.</p>";
}
?>

<form id="addUserForm" action="../../controller/authController.php" method="post" onsubmit="return validateForm()">
    <label>Name:</label><br>
    <input type="text" id="name" name="name"><br>
    <span id="nameErr"></span><br>

    <label>Email:</label><br>
    <input type="email" id="email" name="email"><br>
    <span id="emailErr"></span><br>

    <label>Password:</label><br>
    <input type="password" id="password" name="password"><br>
    <span id="passErr"></span><br>

    <label>Age:</label><br>
    <input type="number" id="age" name="age"><br>
    <span id="ageErr"></span><br>

    <label>Gender:</label><br>
    <input type="radio" id="male" name="gender" value="Male"> Male
    <input type="radio" id="female" name="gender" value="Female"> Female<br>
    <span id="genderErr"></span><br>

    <label>Role:</label><br>
    <select id="roleId" name="roleId">
        <option value="">Select Role</option>
        <option value="2">Admin</option>
    </select><br>
    <span id="roleErr"></span><br>

    <button type="submit" name="add_user">Add Admin</button>
</form>

<script src="../js/validateAddUser.js"></script>

</body>
</html>
