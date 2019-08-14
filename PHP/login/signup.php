<?php
    require "header.php";
?>
<main>
<div class="container" style="margin-top: 100px">
        <div class="row justify-content-center">
            <div class="col-md-6 col-offset-3" align="center">
                <h1>Sign Up</h1>
                <?php
                    if(isset($_GET['error']))
                    {
                        if($_GET['error'] == "emptyfields")
                        {
                            echo "Please fill all fields";
                        }
                        else if($_GET['error'] == "invaliduidmail")
                        {
                            echo "Invalid mail";
                        }
                    }
                    /*else if($_GET['signup'] == "success")
                    {
                        echo "Sign up successful";
                        
                    }*/
                ?>
                <form action="http://167.71.227.193:420/login/includes/signup.inc.php" method="POST">
                    <div class="form-group">
                        <label for="InputEmail1">Email address</label>
                        <input type="email" name="email_id" class="form-control" id="InputEmail" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="UserName">User Name</label>
                        <input type="name" name="name" class="form-control" id="Username" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="InputPassword1">Password</label>
                        <input type="password" name="pwd" class="form-control" id="InputPassword1" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="InputPassword2">Confirm Password</label>
                        <input type="password" name="pwd-repeat" class="form-control" id="exampleInputPassword2" placeholder="Repeat Password">
                    </div>

                    <button type="submit" class="btn btn-primary" name="signup-submit">Sign Up</button>

                
                </form>
                </div> 

            </div>
               
        </div>
</div>
</main>

<?php
    require "footer.php";
?>
