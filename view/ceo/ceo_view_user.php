<?php
session_start();
require_once("../../controller/userController.php");

if (!isset($_SESSION["userId"]) || $_SESSION["RoleId"] != 1) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    echo "<p>Invalid user ID.</p>";
    exit;
}

$userId = intval($_GET["id"]);
$user = fetchUserDataById($userId);
if (!$user) {
    echo "<p>User not found.</p>";
    exit;
}

$msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["update_user"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $role = intval($_POST["role"]);
        $age = intval($_POST["age"]);
        $gender = $_POST["gender"];
        if (editUser($userId, $name, $email, $role, $age, $gender)) {
            $msg = "User updated successfully!";
            $user = fetchUserDataById($userId);
        } else {
            $msg = "Failed to update user.";
        }
    }

    if (isset($_POST["change_password"])) {
        $newPass = $_POST["new_password"];
        if (changeUserPassword($userId, $newPass)) {
            $msg = "Password updated successfully!";
        } else {
            $msg = "Failed to update password.";
        }
    }
}
$name=$_SESSION["Name"];
?>
<!DOCTYPE html>
<head>
<title>Manage User</title>
 <link rel="stylesheet" href="../css/ceo_view_user_style.css">
</head>
<body>

<?php  echo "<h1>Welcome ".$name."</h1>" ?>
<a class="back" href="manage_user.php">← Back to Accounts</a>

<?php if ($msg): ?>
    <p class="msg"><?= htmlspecialchars($msg) ?></p>
<?php endif; ?>

<h2>Edit User Info</h2>
<form method="post">
    <label>Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($user['Name']) ?>" required><br>

    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['Email']) ?>" required><br>

    <label>Role ID:</label>
    <select name="role" required>
        <option value="1" <?= $user['RoleId']==1?'selected':'' ?>>CEO</option>
        <option value="2" <?= $user['RoleId']==2?'selected':'' ?>>Admin</option>
        <option value="3" <?= $user['RoleId']==3?'selected':'' ?>>Manager</option>
        <option value="4" <?= $user['RoleId']==4?'selected':'' ?>>Employee</option>
    </select><br>

    <label>Age:</label>
    <input type="number" name="age" value="<?= htmlspecialchars($user['Age']) ?>"><br>

    <label>Gender:</label>
    <select name="gender">
        <option value="Male" <?= $user['Gender']=='Male'?'selected':'' ?>>Male</option>
        <option value="Female" <?= $user['Gender']=='Female'?'selected':'' ?>>Female</option>
        <option value="Other" <?= $user['Gender']=='Other'?'selected':'' ?>>Other</option>
    </select><br>

    <button type="submit" name="update_user" class="update">Update User</button>
</form>

<h2>Delete User</h2>
<form action="../../controller/authController.php" method="post" onsubmit="return confirm('Are you sure you want to delete this user?');">
    <input type="hidden" name="userId" value="<?= $userId; ?>">
    <button type="submit" name="delete" class="delete">Delete User</button>
</form>

</body>
</html>
