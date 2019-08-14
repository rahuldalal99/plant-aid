<?php
    if(isset($_POST['log-in']))
    {
        require 'dbh.inc.php';
        
        $mailuid = $_POST['email-id'];
        $password = $_POST['pwd'];

        if(empty($mailuid) || empty($password))
        {
            header("Location: http://167.71.227.193:420/login/index.php?error=emptyfields");
            exit();

        }
        //Check database, get password and authenticate
        else
        {
            $sql = "SELECT * from USERS WHERE email_id='$mailuid'";
            //$stmt = mysqli_stmt_init($conn);
            /*if(!mysqli_stmt_prepare($stmt, $sql))
            {
                header("Location: http://167.71.227.193/login/index.php?error=sqlerror");
                exit();
            }
            else*/
            {
                /*mysqli_stmt_bind_param($stmt, "s", $mailuid);
                mysqli_stmt_execute($stmt);*/
                $result = pg_query($dbconn,$sql);
                if($row = pg_fetch_assoc($result))
                {
                    $pwdCheck = password_verify($password, $row['passwd']);
                    if($pwdCheck == false)
                    {
                        header("Location: http://167.71.227.193:420/login/index.php?error=wrongpwd");
                        exit();
                    }
                    //Log the user in
                    else if($pwdCheck == true)
                    {
                       	session_start();
                        $_SESSION['userId'] = $row['name'];

                        header("Location: http://167.71.227.193:420/upload.php?login=success");
                        exit();

                    }
                    else
                    {
                        header("Location: http://167.71.227.193:420/login/index.php?error=wrongpwd");
                        exit();
                    }
                }
                else{
                    header("Location: http://167.71.227.193:420/login/index.php?error=nouser");
                    exit();
                }
            }

        }
    }
    else
    {
        header("Location: http://167.71.227.193:420/login/index.php");
        exit();
    }
