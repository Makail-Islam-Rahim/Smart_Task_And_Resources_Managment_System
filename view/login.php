<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="css/login_style.css">
</head>
<body>
    <form action="../controller/authController.php" method="POST">
        <label for="userId">User ID:</label>
        <input type="text" name="userId">
        <span name="userIderr"><?php if(isset($_GET["idErr"])){echo $_GET["idErr"]; } ?></span>

        <label for="pass">Password:</label>
        <input type="password" name="pass">
        <span name="passerr"><?php if(isset($_GET["passErr"])){echo $_GET["passErr"]; } ?></span>

        <input type="submit" name="submit" value="Login">
        <span name="invalidUser"><?php if(isset($_GET["invalidUser"])){echo $_GET["invalidUser"]; } ?></span>
    </form>
</body>
</html>
