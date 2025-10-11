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

?>