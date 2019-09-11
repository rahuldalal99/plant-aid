<?php
	session_start();
	require "header.php";
	if(isset($_SESSION['userid'])){//User is logged in
		header ("Location: http://medivine.me:420/index.php");//Redirect logged in user to upload
	}
	else{
echo "
<main>
<div class=\"container\" style=\"margin-top: 100px\">
        <div class=\"row justify-content-center\">
            <div class=\"col-md-6 col-offset-3\" align=\"center\">
                <h2>Sign Up</h2>";//End of echo
                    if(isset($_GET['error']))
                    {
                        if($_GET['error'] == "emptyfields")
                        {
                            echo "<h6 class='error'>Please fill all fields</h6>";
                        }
                        else if($_GET['error'] == "invaliduidmail")
                        {
                            echo "<h6 class='error'>Invalid mail</h6>";
			}
			if($_GET['error'] == "invaliduid")
			{
				echo "<h6 class='error'>Invalid Username</h6>";

			}
			if($_GET['error'] == "passwordcheck")
			{
				echo "<h6 class='error'>Passwords do not match</h6>";
			}
			
			if($_GET['error'] == "userexists")
			{
				echo "<h6 class='error'>Email already taken</h6>";
			}	
		    }
		    echo "
                <form action=\"http://medivine.me:420/login/includes/signup.inc.php\" method=\"POST\">
                    <div class=\"form-group\">
                        <label for=\"InputEmail1\">Email address</label>
                        <input type=\"email\" name=\"email_id\" class=\"form-control\" id=\"InputEmail\" aria-describedby=\"emailHelp\" placeholder=\"Enter email\">
                    </div>
                    <div class=\"form-group\">
                        <label for=\"UserName\">User Name</label>
                        <input type=\"name\" name=\"name\" class=\"form-control\" id=\"Username\" placeholder=\"Enter Name\">
                    </div>
                    <div class=\"form-group\">
                        <label for=\"InputPassword1\">Password</label>
                        <input type=\"password\" name=\"pwd\" class=\"form-control\" id=\"InputPassword1\" placeholder=\"Password\">
                    </div>
                    <div class=\"form-group\">
                        <label for=\"InputPassword2\">Confirm Password</label>
                        <input type=\"password\" name=\"pwd-repeat\" class=\"form-control\" id=\"exampleInputPassword2\" placeholder=\"Repeat Password\">
                    </div>

                    <button type=\"submit\" class=\"btn btn-dark\" name=\"signup-submit\">Sign Up</button>

                </form>
                </div>

            </div>

        </div>
</div>
</main>
	";//end of 2ndecho for else
	}//End of else



		        require "footer.php";
?>
