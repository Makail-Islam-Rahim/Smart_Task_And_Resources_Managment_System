<?php
require_once('db.php');

function getPendingResourceRequestsModel() {
    $conn = getConnection();
    if(!$conn) return false;
    $sql = "SELECT * FROM resource WHERE status='Pending' ORDER BY Request_ID DESC";
    $res = mysqli_query($conn, $sql);
    $data = [];
    if($res){
        while($r = mysqli_fetch_assoc($res)) $data[] = $r;
    }
    mysqli_close($conn);
    return $data;
}

function updateResourceStatusModel($id, $status) {
    $conn = getConnection();
    if(!$conn) return false;
    $id = intval($id);
    $status = mysqli_real_escape_string($conn, $status);
    $sql = "UPDATE resource SET status='$status' WHERE Request_ID=$id";
    $res = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $res;
}
?>