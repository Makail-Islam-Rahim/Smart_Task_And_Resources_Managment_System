<?php
session_start();
require_once("../../controller/userController.php");

//Only admins can access
if (!isset($_SESSION["userId"]) || $_SESSION["RoleId"] != 2) {
    header("Location: ../login.php");
    exit;
}

//Get user info
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

//Handle CRUD form submissions
$msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["update_user"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $role = intval($_POST["role"]);
        $age = intval($_POST["age"]);
        $gender = $_POST["gender"];
        if (editUser($userId, $name, $email, $role, $age, $gender)) {
            $msg = "✅ User updated successfully!";
            $user = fetchUserDataById($userId); // refresh data
        } else {
            $msg = "❌ Failed to update user.";
        }
    }

    if (isset($_POST["change_password"])) {
        $newPass = $_POST["new_password"];
        if (changeUserPassword($userId, $newPass)) {
            $msg = "🔑 Password updated successfully!";
        } else {
            $msg = "❌ Failed to update password.";
        }
    }

    if (isset($_POST["delete_user"])) {
        if (removeUser($userId)) {
            header("Location: accounts.php?deleted=1");
            exit;
        } else {
            $msg = "❌ Failed to delete user.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="../css/admincss/common.css">
<link rel="stylesheet" href="../css/admincss/view_user.css">

<meta charset="UTF-8">
<title>Manage User</title>

</head>
<body>

<h1>Manage User #<?= htmlspecialchars($user['userId']) ?></h1>
<a class="back" href="accounts.php">← Back to Accounts</a>

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

<h2>Change Password</h2>
<form method="post">
    <label>New Password:</label>
    <input type="password" name="new_password" required><br>
    <button type="submit" name="change_password" class="pass">Change Password</button>
</form>

<h2>Delete User</h2>
<form method="post" onsubmit="return confirm('Are you sure you want to delete this user?');">
    <button type="submit" name="delete_user" class="delete">Delete User</button>
</form>

</body>
</html>
