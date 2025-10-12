<?php
require_once('db.php');

function validateUsers($id, $pass)
{
    $conn = getConnection();
    $id = mysqli_real_escape_string($conn, $id);
 
    $sql = "SELECT * FROM user WHERE userId='$id' OR Email='$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
 
    if ($row && password_verify($pass, $row['Password'])) {
        return $row;
    } else {
        return false;
    }
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

function updateUser($userId, $name, $email, $roleId, $age, $gender)
{
    $conn = getConnection();
    if (!$conn) return false;

    $userId = intval($userId);
    $name = mysqli_real_escape_string($conn, $name);
    $email = mysqli_real_escape_string($conn, $email);
    $gender = mysqli_real_escape_string($conn, $gender);

    $sql = "UPDATE user
            SET Name='$name', Email='$email', RoleId=$roleId, Age=$age, Gender='$gender'
            WHERE userId=$userId";

    $res = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $res;
}

function updateUserPassword($userId, $newPassword)
{
    $conn = getConnection();
    if (!$conn) return false;

    $userId = intval($userId);
    $hashed = password_hash($newPassword, PASSWORD_DEFAULT);

    $sql = "UPDATE user SET Password='$hashed' WHERE userId=$userId";
    $res = mysqli_query($conn, $sql);

    mysqli_close($conn);
    return $res;
}

function deleteUser($userId)
{
    $conn = getConnection();
    if (!$conn) return false;

    $userId = intval($userId);
    $sql = "DELETE FROM user WHERE userId=$userId";
    $res = mysqli_query($conn, $sql);

    mysqli_close($conn);
    return $res;
}
function emailExists($email){
    $conn = getConnection();
    $query = "SELECT * FROM user WHERE Email='$email'";
    $result = mysqli_query($conn, $query);
    $exists = false;
    if(mysqli_num_rows($result) > 0){
        $exists = true;
    }
    mysqli_close($conn);
    return $exists;
}

function insertUser($name, $email, $password, $roleId, $age, $gender){
    $conn = getConnection();
    if(emailExists($email)){
        return false;
    }
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO user (Name, Email, Password, RoleId, Age, Gender) 
            VALUES ('$name', '$email', '$hashed', '$roleId', '$age', '$gender')";
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}
?>