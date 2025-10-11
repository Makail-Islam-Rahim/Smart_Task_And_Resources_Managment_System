<?php


include('../model/db.php'); // ✅ connect to DB
    session_start();
    $conn=getConnection();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request_resource'])) {


    $resource_name = $_POST['resource_name'];
    $resource_amount = $_POST['resource_amount'];
    $request_by = $_SESSION['userId'];  // ✅ from session
    $status = 'pending';

    // find manager or admin (RoleId = 2)
    $result = mysqli_query($conn, "SELECT userId FROM user WHERE RoleId = 2 LIMIT 1");
    $row = mysqli_fetch_assoc($result);
    $request_to = $row['userId'];

    // insert request
    $sql = "INSERT INTO resource (resource_name, status, resource_amount, request_by, request_to)
            VALUES ('$resource_name', '$status', '$resource_amount', '$request_by', '$request_to')";

   if (mysqli_query($conn, $sql)) {
        $_SESSION['success_message'] = "Resource request submitted successfully!";
        header("Location: ../employee/resource.php");
    } 
    else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>
