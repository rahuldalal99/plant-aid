<?php
    require "header.php";
?>
<main>
<!-- We can add this part in header.php as just log in button and redirect the user to login page -->

  <div class="container" style="margin-top: 100px">
        <div class="row justify-content-center">
            <div class="col-md-6 col-offset-3" align="center">
                <h1>Welcome to MediVine</h1>
                <h2>Towards resolving plant disease using AI</h2>
		<?php
	if(isset($_GET['error'])){//Restricting access to upload without logging in Rahul 17-08 9:45pm
		echo "<h6 class=error> Log-in to continue!</h6>";
		exit();
			}
		?>
                
               

            </div>
               
        </div>
</div>
</main>

<?php
    require "footer.php";
?>
