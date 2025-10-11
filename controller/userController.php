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

?>