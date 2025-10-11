<?php

session_start();
    include ('../../model/db.php');
    
 
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request_resource'])) {
        $request_id=$_POST['request_id'];
        $resource_name=$_POST['resource_name'];
        $status=$_POST['status'];
        $resource_amount=$_POST['resource_amount'];
        $request_by=$_POST['request_by'];
        $request_to=$_POST['request_to'];
        $request_by = $_SESSION['userId'];
        $result = mysqli_query($conn, "SELECT userId FROM user WHERE RoleId = 2 LIMIT 1");
        $row = mysqli_fetch_assoc($result);
        $request_to = $row['userId'];
        $status = 'pending';

    $sql = "INSERT INTO resource (request_id, resource_name,status, resource_amount,request_by, request_to)
            VALUES ('$request_id', '$resource_name', '$status', '$resource_amount', '$request_by', '$request_to')";

    if ($conn->query($sql) === TRUE) {
       echo "Resource request submitted successfully! ";

        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}


?>
<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
    <div class="header" id="myHeader">
    <?php  echo "<h1>Welcome "."</h1>" ?>
    <div class="side-menu">
        <ul>
            <li><?php echo "<a href='home.php'>Home</a>" ?></li>
            <li><?php echo "<a href='profile.php'>Profile</a>" ?></li>    
            <li><?php echo "<a href='resource.php'>Resources</a>"?></li>
            <li><?php echo "<a href='../logout.php'>logout</a>" ?></li>
        </ul>
    </div>

    </div>

    <div class="container">
    <h2>Request a Resource</h2>
    <form method="post" action="../../controller/resourceController.php">
        <label>Resource Name:</label><br>
        <input type="text" name="resource_name" required><br><br>

        <label>Resourse Amount:</label><br>
        <input type="number" name="resource_amount" min="1" value="1" required><br><br>

        <label>Request To:</label><br>
        <textarea name="reason" rows="3"></textarea><br><br>

        <button type="submit" name="request_resource">Submit Request</button>
    </form>
</div>
    

    
    </body>
</html>