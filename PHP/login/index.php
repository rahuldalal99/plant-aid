<?php
	session_start();
	//print_r($_SESSION);
	require "header.php";
	$user = $_SESSION['userid'];
	
	
?>
<main>
<!-- We can add this part in header.php as just log in button and redirect the user to login page  container style=margin-top:100px--> 
<div class="parallax"> 
  <div class="contai
ner">
	<div class="row justify-content-center">
	    <div class="col-md-6 col-offset-3" align="center">
	    <h1 style="color:#f9f9f9">Welcome <?php echo $user;?></h1>
		<h2 style="color:#f9f9f9"><i>Towards resolving plant disease using AI</i></h2>
		<?php
	if(isset($_GET['error'])){//Restricting access to upload without logging in Rahul 17-08 9:45pm
		echo "<h6 class=error> Log-in to continue!</h6>";
		exit();
			}
		?>
               <!-- <br><br><br> <h2 style="color:#f9f9f9"> <a href="../upload.php" style="color:#f9f9f9" > Get Started </a></h2>-->

            </div>       
	</div>

	<div class="row justify-content-center">
		
		 <div class="col-md-10 col-offset-1" align="center">
		 <div style="background-color:#fff;" class="jumbotron"> <?php echo readfile('info.txt'); ?> </div>
		</div>
	</div><!--row 2-->
<?php
	if(isset($_SESSION['userid'])){
	echo"	<div class=\"row justify-content-center\"> 
		<div class=\"col-md-2 col-offset-3\">
		<form action=\"http://medivine.me:420/previous.php\"> 
			<button class=\"transparent_btn\" >Previous Uploads</button>
		</form>
		</div><!--Previous -->
		<div class=\"col-md-2 col-offset-2\">
		<form action=\"http://medivine.me:420/upload.php\">
			<button class=\"transparent_btn\"> Upload Image </button>
		</form>	
		</div>
		";
	}
?>
</div> <!-- Parallax end div-->
</div>
</main>

<?php
    require "footer.php";
?>
