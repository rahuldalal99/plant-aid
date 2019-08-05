<?php
//Add Database information 
/*$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "Users";*/
$str = "host=localhost dbname=Users user=root ";

$conn = pg_connect($str);
if(!$conn){
	echo "Cannot connect: ". pg_last_error($conn);
}
?>