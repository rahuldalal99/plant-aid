<?php
	//session_start();
	require('login/header.php');
//	echo "<link rel=\"stylesheet\" href=\"login/styles.css\">";
	require('utility.php');
	$result=getFiles($_SESSION['email'],$dbconn);
	$files=$result[2];
	$dates=$result[0];
	$preds=$result[1];
	$i=0;
	echo "<table><tr><th>IMG</th><th>DATE</th><th>PRED</th></tr>";
	foreach($files as $file){
		if(!empty($preds[$i])){
		
		echo "<tr><td><img style=\"max-width:150px; max-height:150px;\" src='$file'></td><td>".$dates[$i]."</td><td>".$preds[$i]."</td></tr>";
		$i++;
		}
		else{
			$i++;
		}
	}
?>

