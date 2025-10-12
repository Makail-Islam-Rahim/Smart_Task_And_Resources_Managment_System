<?php
function getConnection()
{
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "smart_task_managemet";
    $port = 3306;
 
 
    $conn = mysqli_connect($host, $user, "", $db, $port);
 
    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }
 
    return $conn;
}
?>
