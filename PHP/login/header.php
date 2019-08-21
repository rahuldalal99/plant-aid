<?php
    session_start();
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="http://167.71.227.193:420/login/styles.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">



    <title>MediVine</title>
  </head>
  <body>
      <header>
	<div>
	    <nav>
<?php 	
			if(!isset($_SESSION['userid'])){
				
		echo"
                	<a href=\"http://167.71.227.193:420/login/signup.php\">Sign up</a>
				<a href=\"http://167.71.227.193:420/login/login.php\">Sign in</a> ";
			
			}
			else{
				echo "<a href=\"http://167.71.227.193:420/login/includes/logout.inc.php\"> Logout </a>  ";
			}
?>
			<a href="http://167.71.227.193:420/login/index.php">Home</a>`
	    </nav>
	</div>
     </header>
