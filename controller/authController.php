<?php
    require_once("userController.php");
    session_start();
    require_once("../model/db.php");
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
                
                $_SESSION["userId"]=$returnedValue["userId"];
                $_SESSION["RoleId"]=$returnedValue["RoleId"];
                $_SESSION["Name"]=$returnedValue["Name"];
                $_SESSION["email"]=$returnedValue["Email"];
                $_SESSION["age"]=$returnedValue["Age"];

                if($returnedValue["RoleId"]==2)
                {
                    
                    header("location:../view/admin/home.php");
                }

                elseif($returnedValue["RoleId"]==4)
                {
                    header("location:../view/employee/home.php");
                }
                elseif($returnedValue["RoleId"]==3)
                {
                    header("location:../view/manager/home.php");
                }
                elseif($returnedValue["RoleId"]==1)
                {
                    header("location:../view/ceo/home.php");
                }

                else
                {
                    header("location:../index.php");
                }
                
            }
        }
    }

        if(isset($_SESSION["userId"]))
    {
        if(isset($_SESSION["RoleId"]) && $_SESSION["RoleId"] == 1)
    {
        header("Location:ceo/manage_user.php");
        
    }
    
    else
        {
             header("Location:client/home.php");   
        }

    }

    else
    {

    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
        $userId = $_POST["userId"];
        $result = removeUser($userId);
        if($result)
        {
                 if (isset($_SESSION["RoleId"])) {
            switch ($_SESSION["RoleId"]) {
                case 1: // CEO
                    header("Location: ../view/ceo/manage_user.php");
                    exit;
                case 2: // Admin
                    header("Location: ../view/admin/accounts.php");
                    exit;
                case 3: // Manager
                    header("Location: ../view/manager/accounts.php");
                    exit;
                case 4: // Employee (if needed)
                    header("Location: ../view/employee/accounts.php");
                    exit;
                default:
                    header("Location: ../index.php");
                    exit;
            }
        } else {
            header("Location: ../index.php");
            exit;
        }
    }
        else
        {
            echo "Delete failed";
        }
    }

    


    if (isset($_POST["add_user"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $roleId = $_POST["roleId"];
        $age = $_POST["age"];
        $gender = $_POST["gender"];

        $result = addUser($name, $email, $password, $roleId, $age, $gender);

        if ($result) {
           header("Location: ../view/ceo/accounts.php");
        } else {
            echo "<script>alert('Failed to add user!'); window.location.href='../view/admin/account.php';</script>";
        }
    }
?>




