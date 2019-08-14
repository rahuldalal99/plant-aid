<?php
    require "header.php";
?>
<main>
<!-- We can add this part in header.php as just log in button and redirect the user to login page -->
<div class="container" style="margin-top: 100px">
        <div class="row justify-content-center">
            <div class="col-md-6 col-offset-3" align="center">
                <h1>Welcome to MediVine</h1>
                <form action="http://139.59.70.219:420/login/includes/login.inc.php" method="POST">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" name="email-id" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password"  name="pwd" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    <button type="submit" name="log-in" class="btn btn-primary">Log In</button>
                    <input type="button" onclick="window.location ='<?php // echo $login_url; ?>';" value="Log in with Google" class="btn btn-primary">
		</form>
                <h1>OR</h1>
                <div class="col-md-6 col-offset-3" align="center">
                    <form action="http://139.59.70.219:420/login/signup.php" method="POST">
                        <button type="submit" class="btn btn-primary">Sign UP</button>
                    </form>
                </div> 

                <?php
                      if(isset($_SESSION['userId']))
                      {
                        echo '<div class="col-md-6 col-offset-3" align="right">
   	                   <form action="http://139.59.70.219:420/login/includes/logout.inc.php" method="POST">
                            <button type="submit" name="logout-submit" class="btn btn-primary">Log Out</button>
                        </form>
                        </div>'; 
                     }
                ?>

               

            </div>
               
        </div>
</div>
</main>

<?php
    require "footer.php";
?>
