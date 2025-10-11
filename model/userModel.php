<?php
require_once('db.php');

function validateUsers($id, $pass)
{
       $conn=getConnection();
        $sql="SELECT * FROM user WHERE userID='$id' And Password='$pass'";
        $result=mysqli_query($conn, $sql);
        $row=mysqli_fetch_assoc($result);
        return $row;
}

function getAllUsers()
{
    $conn = getConnection();
    if(!$conn) return false;
    $sql = "SELECT userId, Name, Email, RoleId, Age, Gender FROM user";
    $res = mysqli_query($conn, $sql);
    $data = [];
    while($r = mysqli_fetch_assoc($res)) $data[] = $r;
    return $data;
}

function getTasksAssignedToUser($userId)
{
    $conn = getConnection();
    if(!$conn) return false;
    $userId = intval($userId);
    $sql = "SELECT t.* FROM task t JOIN task_assignment ta ON t.taskID = ta.taskID WHERE ta.assigned_To = $userId";
    $res = mysqli_query($conn, $sql);
    $data = [];
    while($r = mysqli_fetch_assoc($res)) $data[] = $r;
    return $data;
}

function getAllTasks()
{
    $conn = getConnection();
    if(!$conn) return false;
    $sql = "SELECT * FROM task";
    $res = mysqli_query($conn, $sql);
    $data = [];
    while($r = mysqli_fetch_assoc($res)) $data[] = $r;
    return $data;
}

function getReports()
{
    $conn = getConnection();
    if(!$conn) return false;
    $sql = "SELECT * FROM performance_report";
    $res = mysqli_query($conn, $sql);
    $data = [];
    while($r = mysqli_fetch_assoc($res)) $data[] = $r;
    return $data;
}

function getUserDataById($userId)
{
    $conn = getConnection();
    if (!$conn) return false;

    $userId = intval($userId);
    $sql = "SELECT * FROM user WHERE userId = $userId";

    $result = mysqli_query($conn, $sql);
    if (!$result) return false;

    $user = mysqli_fetch_assoc($result);
    mysqli_close($conn);

    return $user;
}



?>