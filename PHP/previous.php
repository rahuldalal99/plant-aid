<?php
	//session_start();
	require('login/header.php');
//	echo "<link rel=\"stylesheet\" href=\"login/styles.css\">";
        //require('utility.php');
	if(!isset($_SESSION['userid']))
	{
		header("Location: http://medivine.me:420/index.php?");
		exit();
	}
	require('utility.php');
	$result=getFiles($_SESSION['email'],$dbconn);
	$files=$result[2];
	$dates=$result[0];
	$preds=$result[1];
	$i=0;
	echo "<table><tr><th style='padding:20px;'>IMG</th><th style='padding:20px;'>DATE</th><th style='padding:20px;'>PREDICTION</th></tr>";
	foreach($files as $file){
		if(!empty($preds[$i])){
		$p1 = explode("_",$preds[$i]);	
		echo "<tr><td style='padding:20px;'><img style=\"max-width:150px; max-height:150px;\" src='$file'></td><td style='padding:20px;'>".$dates[$i]."</td><td style='padding:20px;'>".$preds[$i]."</td></tr>";
		$i++;
		}
		else{
			$i++;
		}
	}
	
?>

