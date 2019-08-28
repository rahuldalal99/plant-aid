<?php
    require "header.php";
?>

     <?php
        if(isset($_SESSION['userId']))
        {
            echo "Welcome".$_SESSION['userId'];
        }
        else
        {
            echo "You are logged out";
        }
    ?>
