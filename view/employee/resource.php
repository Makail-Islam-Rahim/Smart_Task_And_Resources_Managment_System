<?php

    include ('../../controller/resourceController.php');
    

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