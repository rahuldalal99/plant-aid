<?php
session_start();
require('login/includes/dbh.inc.php');
//Working
//TODO: save file from requests by arbitrary ID, and use that ID below
function uploadFile($target_dir="uploads",$type){ //type = {'profile','plant'} returns path to uploaded and moved file
	$target_file = basename($_FILES["fileToUpload"]["name"]);
	$extension=pathinfo($target_file)['extension'];
	switch($type){
		case "profile": $fName=md5($_SESSION['email']);		
				$fName=$fName.".".$extension;
				break;
		case "plant":	$dateNow=date('d-m-Y');
		                $timeNow=date("h-i-s",time());
		                $fName=md5($_SESSION['email'].$dateNow.$timeNow).'.png';
				break;
		default: die("[!]Error in type");
	}
	if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$target_dir."/".$fName)){
		$fPath_=$target_dir.'/'.$fName;
		echo "<img src=\"".$fPath_."\">";
		$_SESSION['fPath']=$fPath_;	
	}
	$_SESSION['DATE_NOW']=$dateNow;
	$_SESSION['TIME_NOW']=$timeNow;
	//$_SESSION['fPath']=$fPath;
	return ($target_dir."/".$fName);
}
function getFiles($email,$dbconn){
	$sql="select * from user_images where email_id='".$email."'";
	
			$files=array();
			$dates=array();
			$pred=array();
			$result=pg_query($dbconn,$sql);
			$newfile="";
			while($row=pg_fetch_assoc($result)){
				$newfile = $row['image_path'];
				/*$newfile=md5($email.$row["date_upload"].$row["time_upload"]);
				$newfile.=".png";*/
				array_push($files, $newfile);
				array_push($pred, $row["prediction"]);
				array_push($dates, $row["date_upload"]);
			}
				return array($dates,$pred,$files);
}
?>
