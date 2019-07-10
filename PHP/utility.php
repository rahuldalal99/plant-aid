<?php
session_start();
//Working
//TODO: save file from requests by arbitrary ID, and use that ID below
function uploadFile($target_dir="uploads",$type){ //type = {'profile','plant'} returns path to uploaded and moved file
	$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
	$extension=pathinfo($target_file)['extension'];
	switch($type){
		case "profile": $fName=md5($_SESSION['email']);		
				$fName=$fName.".".$extension;
				break;
		case "plant":	$fName=md5($_SESSION['email'].date('d-m-Y').date("h-i-s",time().$extension);
				break;
		case default: die("[!]Error in type");
	}
	rename($fName,$target_dir."/".$fName);
	return ($target_dir."/".$fName);
}
?>
