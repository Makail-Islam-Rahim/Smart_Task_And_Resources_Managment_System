<?php
session_start();
require_once("../model/task_managementModel.php");


if (!isset($_SESSION['userId']) || !in_array($_SESSION['RoleId'], [1,2])) {
    header("Location: ../login.php");
    exit;
}

$employees = get_task_management_employees();

include('../view/view/manager/task_management.php');
?>