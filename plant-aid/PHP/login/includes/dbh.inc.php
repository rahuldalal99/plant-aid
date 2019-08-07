<?php
//Add Database information 
/*$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "Users";*/
$str = "host=localhost dbname=postgres user=postgres password=sas-fc@22";

$conn = pg_connect($str);
if(!$conn){
	echo "Cannot connect: ". pg_last_error($conn);
}

