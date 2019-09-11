<?php
    session_start();
?>
<!doctype HTML>
<html lang="en">
  <head>
    	<!-- Required meta tags -->
    	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1,  	shrink-to-fit=no">
	<link rel="stylesheet" href="http://medivine.me:420/login/styles.css">
    	<!-- Bootstrap CSS -->
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
	<title>medivine.ai</title>
  </head>
  <body>
      <header>
	<div>
	    <nav>
		<?php 	
				if(!isset($_SESSION['userid']))
				{
				echo"
                		<a href=\"http://medivine.me:420/login/signup.php\">Sign up</a>
					<a href=\"http://medivine.me:420/login/login.php\">Sign in</a>  
	";
				echo "
					<a href=\"http://medivine.me:420/index.php\">Home</a> 
					<a class='logo' href='http://medivine.me:420/index.php'> Medivine </a>	
				";
			
			}
			else{
				echo "<a href=\"http://medivine.me:420/login/includes/logout.inc.php\"> Logout </a>   
";
			echo "
			<a href=\"http://medivine.me:420/login/index.php\">Home</a> 
			<a class='logo' href='http://medivine.me:420/index.php'> Medivine </a>	
			";
			}
			
?>
	    </nav>
	</div>
     </header>
