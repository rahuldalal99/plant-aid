<?php
require 'login/header.php';
session_start();
	require 'login/includes/dbh.inc.php';
	$disease=$_SESSION['disease'];
	$plant=$_SESSION['plant'];
	$sql="select * from  disease where disease_name = '$disease'";
	$result=pg_query($dbconn,$sql);
	$row=pg_fetch_assoc($result);
	$disease_id=$row["disease_id"];
	$disease_symptoms=$row["disease_symptoms"];
	$disease_causes=$row["disease_causes"];
	
	//PLANT

	$sql="select plant_id from plant where plant_name='$plant'";
	$result=pg_query($dbconn,$sql);
	$row=pg_fetch_assoc($result);
	$plant_id=$row["plant_id"];
	
	//CURE
	if($plant_id==5){
		$cure="Please go back and select the plant name to get more information about cure.";
	}
	else{
		$sql="select cure from plant_disease where plant_id=$plant_id and disease_id=$disease_id";
		$result=pg_query($dbconn,$sql);
        	$row=pg_fetch_assoc($result);
		$cure=$row["cure"];
	}
	echo "<div class='container'>
			<div class='row justify-content-center'>
				<h1 style='padding:25px;'>Cure</h1>
			</div>
			</div>
		</div>
		<div class='container'>
			<div class='row justify-content-center'>
				<div class='col-md-6  text-center'>
					<h5>Plant: $plant</h5>
				</div>
				<div class='col-md-6 text-center'>
				<h5>Disease: $disease</h5>
				</div>
			</div>
			<hr>
		</div>
			<div class='jumbotron'>
			<h6><b>Symptoms:</b></h6> $disease_symptoms<br>
			</div>
			<div class='jumbotron'>
			<h6><b>Causes:</b></h6> $disease_causes<br>
			</div>
			<div class='jumbotron'>
			$cure<br>
			</div>";
			
	echo"   <div class='container'>
		<div class='row justify-content-center'>
			
		<a  class='btn btn-outline-secondary' href='http://medivine.me:420/upload.php' role='button'> Go Back </a>
		</div>
		</div>";
?>
