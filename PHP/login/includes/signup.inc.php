<?php
    if(isset($_POST['signup-submit']))
    {
       require 'dbh.inc.php'; //includes database handler file
        
	session_start();
        //Fetch Information 
        
        $username = $_POST['name'];
        $email = $_POST['email_id'];
        $password = $_POST['pwd'];
        $passwordRep = $_POST['pwd-repeat'];
        $_SESSION['userid']=$username; //added by TK 14-08 

        /************ *Validate Form *******************/
        if(empty($username) || empty($email) || empty($password) || empty($passwordRep))
        {
            //Redirect user
            header("Location: http://167.71.227.193:420/login/signup.php?error=emptyfields&name=".$username."&mail=".$email);
            exit();
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username))
        {
            
            header("Location: http://167.71.227.193:420/login/signup.php?error=invalidmailuid");
            exit();
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            header("Location: http://167.71.227.193:420/login/signup.php?error=invalidmail&name=".$username);
            exit();
        }
        else if(!preg_match("/^[a-zA-Z0-9]*$/", $username))
        {
            header("http://167.71.227.193:420/login/signup.php?error=invaliuid&mail=".$email);
            exit();
        }
        else if($password !== $passwordRep)
        {
            header("http://167.71.227.193:420/login/signup.php?error=passwordcheck&name=".$username."&mail=".$email);
            exit();
        }
	//If username is already taken
        else
        {
            $sql = "SELECT name FROM users WHERE name='$username'"; // ? is a placeholder 
            //Passing values as Prepared Statements for safety purposes 

            //$stmt = mysqli_stmt_init($conn);
            //Prepare the preparec statement
            if(!pg_query($dbconn, $sql))
            {
                header("http://167.71.227.193:420/login/signup.php?error=sqlerror");
                exit();
            }
            else
            {
                /*//Bind parametres to the placeholers
                mysqli_stmt_bind_param($stmt, "s", $username);
                //Run parameters inside database
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if($resultCheck > 0)
                {
                    header("Location: ../signup.php?error=usetaken");
                    exit();
                }*/
                //INSERT INTO DATABASE
                
                
                    /*$sql = "INSERT INTO users(email_id,name,passwd,)  VALUES('$username', '$email','$password')";
                    //$stmt = mysqli_stmt_init($conn);
                    if(!pg_query($conn, $sql))
                    {
                        header("Location: ../signup.php?error=sqlerror");
                        exit();
                    }*/
			
			$q1= "SELECT email_id FROM users WHERE email_id='$email'";
			$res = pg_query($dbconn,$q1);
			$count = pg_num_rows($res);
			if($count>0){
				echo "Email ID already registered";
				header("Location: http://167.71.227.193:420/login/signup.php?error=userexists");
				exit();
			}
			//HASH THE PASSWORD
                        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
			$sql = "INSERT INTO users(email_id,name,passwd)  VALUES('$email', '$username','$hashedPwd')";
			$res = pg_query($dbconn, $sql) or die("Cannot insert into DB");
  
  	//echo pg_last_error($dbconn);
                       // mysqli_stmt_bind_param($stmt, "sss",$username,$email,$hashedPwd);
                        //pg_query($dbconn,$sql) or die ("cannot insert into DB");
                        header("Location: http://167.71.227.193:420/upload.php");
                        exit(); 
                    
                
            }
        }
        /*mysqli_stmt_close($stmt);
        mysqli_close($conn);*/
      

    }
    else//
    {
        header("http://167.71.227.193:420/login/signup.php");
        exit();
    }
