<?php
//Add Database information 
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "Users";

$conn = mysqli_connect($servername, $dbUsername , $dbPassword, $dbName);

if(!$conn)
{
    die("Connect failed: ".mysqli_connect_error());
}