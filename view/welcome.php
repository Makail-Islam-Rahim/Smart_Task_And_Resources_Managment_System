<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
echo "Welcome " . $_SESSION['name'] . " (" . $_SESSION['role'] . ")";
?>
<br><a href="logout.php">Logout</a>
