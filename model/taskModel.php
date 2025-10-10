<?php
    require_once("db.php");

    function getAllTask()
    {
        $conn=getConnection();
        $sql="SELECT * FROM task WHERE userID='$id' And Password='$pass'";
        $result=mysqli_query($conn, $sql);
        $row=mysqli_fetch_assoc($result);
        return $row;
    }

?>