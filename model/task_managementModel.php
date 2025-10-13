<?php
require_once('db.php');

function get_task_management_employees() {
    $conn = getConnection();
    if (!$conn) return false;
    $sql = "SELECT userId, Name FROM user WHERE RoleId = 4";
    $res = mysqli_query($conn, $sql);
    $data = [];
    while ($r = mysqli_fetch_assoc($res)) {
        $data[] = $r;
    }
    mysqli_close($conn);
    return $data;
}

?>