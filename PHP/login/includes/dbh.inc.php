<?php
//Add Database information 
/*$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "Users";*/
$str = "host=localhost dbname=postgres user=postgres password=postgres";

$dbconn = pg_connect($str);
if(!$dbconn){
	echo "Cannot connect: ". pg_last_error($dbconn);
}
