<?php
session_start();
$_SESSION['email']='tanay@gmail.com';
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
	move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$target_dir."/".$fName);
	$_SESSION['DATE_NOW']=$dateNow;
	$_SESSION['TIME_NOW']=$timeNow;
	return ($target_dir."/".$fName);
}
?>
