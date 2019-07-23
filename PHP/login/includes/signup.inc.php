<?php
    if(isset($_POST['signup-submit']))
    {
        require 'dbh.inc.php'; //includes database handler file
        

        //Fetch Information 
        
        $username = $_POST['name'];
        $email = $_POST['email_id'];
        $password = $_POST['pwd'];
        $passwordRep = $_POST['pwd-repeat'];

        /************ *Validate Form *******************/
        if(empty($username) || empty($email) || empty($password) || empty($passwordRep))
        {
            //Redirect user
            header("Location: ../signup.php?error=emptyfields&name=".$username."&mail=".$email);
            exit();
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username))
        {
            
            header("Location: ../signup.php?error=invalidmailuid");
            exit();
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            header("Location: ../signup.php?error=invalidmail&name=".$username);
            exit();
        }
        else if(!preg_match("/^[a-zA-Z0-9]*$/", $username))
        {
            header("Location: ../signup.php?error=invaliuid&mail=".$email);
            exit();
        }
        else if($password !== $passwordRep)
        {
            header("Location: ../signup.php?error=passwordcheck&name=".$username."&mail=".$email);
            exit();
        }
        //If username is already taken

        else
        {
            $sql = "SELECT name FROM users WHERE name=?"; // ? is a placeholder 
            //Passing values as Prepared Statements for safety purposes 

            $stmt = mysqli_stmt_init($conn);
            //Prepare the preparec statement
            if(!mysqli_stmt_prepare($stmt, $sql))
            {
                header("Location: ../signup.php?error=sqlerror");
                exit();
            }
            else
            {
                //Bind parametres to the placeholers
                mysqli_stmt_bind_param($stmt, "s", $username);
                //Run parameters inside database
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if($resultCheck > 0)
                {
                    header("Location: ../signup.php?error=usetaken");
                    exit();
                }
                //INSERT INTO DATABASE
                else
                {
                    $sql = "INSERT INTO users(email_id,name,passwd,)  VALUES(?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql))
                    {
                        header("Location: ../signup.php?error=sqlerror");
                        exit();
                    }
                    else
                    {
                        //HASH THE PASSWORD
                        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

                        mysqli_stmt_bind_param($stmt, "sss",$username,$email,$hashedPwd);
                        mysqli_stmt_execute($stmt);
                        header("Location: ../signup.php?signup=success");
                        exit();
                        
                    }
                    
                }
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        

    }
    else
    {
        header("Location: ../signup.php");
        exit();
    }