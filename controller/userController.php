<?php
require_once(__DIR__ . '/../model/userModel.php');

function validateUser($id, $pass)
{
    return validateUsers($id, $pass);
}

function fetchAllUsers()
{
    return getAllUsers();
}

function fetchAllTasks()
{
    return getAllTasks();
}

function fetchUserTasks($userId)
{
    return getTasksAssignedToUser($userId);
}

function fetchReports()
{
    return getReports();
}

function fetchUserDataById($userId)
{
    return getUserDataById($userId);
}

function editUser($userId, $name, $email, $roleId, $age, $gender)
{
    return updateUser($userId, $name, $email, $roleId, $age, $gender);
}

function changeUserPassword($userId, $newPassword)
{
    return updateUserPassword($userId, $newPassword);
}

function removeUser($userId)
{
    return deleteUser($userId);
}

function getUserRoleCounts()
{
    $users = getAllUsers();
    $counts = [
        "Admin" => 0,
        "Manager" => 0,
        "Employee" => 0,
        "Total" => 0
    ];

    foreach ($users as $user) {
        switch ($user['RoleId']) {
            case 2:
                $counts["Manager"]++;
                break;
            case 3:
                $counts["Admin"]++;
                break;
            case 4:
                $counts["Employee"]++;
                break;
        }
        $counts["Total"]++;
    }
    return $counts;
}
function addUser($name, $email, $password, $roleId, $age, $gender){
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    return insertUser($name, $email, $passwordHash, $roleId, $age, $gender);
}


?>