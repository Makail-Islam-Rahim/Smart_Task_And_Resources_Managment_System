<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "smart_task_managemet";

function getConnection()
    {
        global $host;
        global $user;
        global $pass;
        global $db;
        global $port;

        $conn=mysqli_connect($host,$user,"",$db);
        return $conn;
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
}
    }
?>
