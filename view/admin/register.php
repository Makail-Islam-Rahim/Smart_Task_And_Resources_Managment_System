<?php
session_start();

include('../../model/db.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];

    $sql = "INSERT INTO user (name, email, password, role, age, gender)
            VALUES ('$name', '$email', '$password', '$role', '$age', '$gender')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful. <a href='login.php'>Login here</a> ";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>

        <div class="header" id="myHeader">
    <div class="side-menu">
        <ul>
            <li><?php echo "<a href='home.php'>Home</a>" ?></li>
            <li ><?php echo "<a href='profile.php'>Profile</a>" ?></li>
            <li><?php echo "<a href='accounts.php'>Accounts</a>" ?></li>
            <li><?php echo "<a href='analytics.php'>Analytics</a>" ?></li>
            <li>Resources</li>
            <li><?php echo "<a href='../logout.php'>logout</a>" ?></li>
        </ul>
    </div>

    <form method="post" action="">
    <h2>Register</h2>
    Name: <input type="text" name="name" required><br>
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    Role:
    <select name="role" required>
        <option value="CEO">CEO</option>
        <option value="Admin">Admin</option>
        <option value="Manager">Manager</option>
        <option value="Employee">Employee</option>
        <option value="Monitor">Monitor</option>
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

    </body>
</html>
