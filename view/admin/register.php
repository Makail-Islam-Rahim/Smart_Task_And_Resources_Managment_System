<?php
session_start();
require_once('../../model/db.php');
 
$conn = getConnection();
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
 
    $sql = "INSERT INTO user (Name, Email, Password, RoleId, Age, Gender)
            VALUES ('$name', '$email', '$password', '$role', '$age', '$gender')";
 
    if (mysqli_query($conn, $sql)) {
        echo "✅ Registration successful. <a href='../login.php'>Login here</a>";
    } else {
        echo "❌ Error: " . mysqli_error($conn);
    }
}
?>
<!doctype html>
<html>
    <head>
<link rel="stylesheet" href="../css/admincss/common.css">
<link rel="stylesheet" href="../css/admincss/register.css">

        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
 
    <div class="header" id="myHeader">
        <div class="side-menu">
            <ul>
                <li><a href='home.php'>Home</a></li>
                <li><a href='profile.php'>Profile</a></li>
                <li><a href='accounts.php'>Accounts</a></li>
                <li><a href='analytics.php'>Analytics</a></li>
                <li><a href='../logout.php'>Logout</a></li>
            </ul>
        </div>
    </div>
        <form method="post" action="">
            <h2>Register</h2>
            Name: <input type="text" name="name" required><br>
            Email: <input type="email" name="email" required><br>
            Password: <input type="password" name="password" required><br>
            Role ID:
            <select name="role" required>
                <option value="1">CEO</option>
                <option value="2">Admin</option>
                <option value="3">Manager</option>
                <option value="4">Employee</option>
            </select><br>
            Age: <input type="number" name="age"><br>
            Gender:
            <select name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select><br>
            <button type="submit">Register</button>
        </form>
    </div>
 
    </body>
</html>
 