<?php
    session_start();

     if(isset($_SESSION["userId"]))
    {
        if(isset($_SESSION["RoleId"])==2)
        {
            
        }

        else
        {
            header("Location:../login.php");
        }

        

    }

    else
    {
        header("Location:../login.php");
    }
    $email=$_SESSION["email"];
    $age=$_SESSION["age"]
 
?>



<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
    <div class="header" id="myHeader">
    <?php  echo "<h1>Welcome ".$age."</h1>" ?>
    <div class="side-menu">
        <ul>
            <li><?php echo "<a href='home.php'>Home</a>" ?></li>
            <li><?php echo "<a href='profile.php'>Home</a>" ?></li>    
            <li>Resources</li>
            <li><?php echo "<a href='../logout.php'>logout</a>" ?></li>
        </ul>
    </div>

    </div>

    <h2>User Details</h2>
    
    

    
    </body>
</html>