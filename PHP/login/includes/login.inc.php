<?php
    if(isset($_POST['log-in']))
    {
        require 'dbh.inc.php';
        
        $mailuid = $_POST['email-id'];
        $password = $_POST['pwd'];

        if(empty($mailuid) || empty($password))
        {
            header("Location: ../index.php?error=emptyfields");
            exit();

        }
        //Check database, get password and authenticate
        else
        {
            $sql = "SELECT * from USERS WHERE name=?;";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql))
            {
                header("Location: ../index.php?error=sqlerror");
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt, "s", $mailuid);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if($row = mysqli_fetch_assoc($result))
                {
                    $pwdCheck = password_verify($password, $row['passwd']);
                    if($pwdCheck == false)
                    {
                        header("Location: ../index.php?error=wrongpwd");
                        exit();
                    }
                    //Lock the user in
                    else if($pwdCheck == true)
                    {
                        session_start();
                        $_SESSION['userId'] = $row['name'];

                        header("Location: ../uploadtest.php?login=success");
                        exit();

                    }
                    else
                    {
                        header("Location: ../index.php?error=wrongpwd");
                        exit();
                    }
                }
                else{
                    header("Location: ../index.php?error=nouser");
                    exit();
                }
            }

        }
    }
    else
    {
        header("Location: ../index.php");
        exit();
    }