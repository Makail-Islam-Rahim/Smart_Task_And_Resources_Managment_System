<?php
    require_once("userController.php");
    $IdErr="";
    $passErr="";
    $hasErr=false;
    $userId="";
    $pass="";
    $email="";
    if(($_SERVER["REQUEST_METHOD"]=="POST") && isset($_POST["submit"]))
    {
        if(empty($_POST["userId"]))
        {
            $IdErr="User id cannot be empty";
            $hasErr=true;

        }

        else
        {
            $userId=$_POST["userId"];
        }

        if(empty($_POST["pass"]))
        {
            $passErr="password cannot be empty";
            $hasErr=true;

        }

        else
        {
            $pass=$_POST["pass"];
        }

        if($hasErr)
        {
            header("Location:../view/login.php?idErr=$IdErr&passErr=$passErr");
        }

        else
        {
            $returnedValue=validateUser($userId, $pass);
            if(!$returnedValue)
            {
                header("Location:../view/login.php?invalidUser='Invalid User.'");
            }

            else
            {
                session_start();
                $_SESSION["userId"]=$returnedValue["userId"];
                $_SESSION["RoleId"]=$returnedValue["RoleId"];
                $_SESSION["Name"]=$returnedValue["Name"];
                $_SESSION["email"]=$returnedValue["Email"];
                $_SESSION["age"]=$returnedValue["Age"];

                if($returnedValue["RoleId"]==1)
                {
                    
                    header("location:../view/admin/home.php");
                }

                elseif($returnedValue["RoleId"]==4)
                {
                    header("location:../view/employee/home.php");
                }
                elseif($returnedValue["RoleId"]==3)
                {
                    header("location:../view/client/home.php");
                }

                else
                {
                    header("location:../view/client/home.php");
                }
                
            }
        }
    }


?>
