<?php
session_start();
if(!isset($_SESSION['userid'])){
	header("Location: http://167.71.227.193:420/login/index.php?error=kbye");
}
echo "welcome " . $_SESSION['userid'];
$_SESSION['email']='tanay@gmail.com';//REPLACE HARDCODED EMAIL
require('utility.php');

echo "

<!DOCTYPE html>
<html>
<body>
<div id=image-div>
</div>
<form action=\"upload.php\" method=\"post\" enctype=\"multipart/form-data\">
    Select image to upload:
    <input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\">
    <input type=\"submit\" value=\"Upload Image\" name=\"submit\">
</form>

</body>
</html>

";
if(isset($_FILES['fileToUpload'])){
//TODO: implement select list for plant leaf name;
// [ Grape , Strawberry, Potato, Tomato ]
// echo "<br>";
// echo md5($_SESSION['email'].$_SESSION['DATE_NOW'].$_SESSION['TIME_NOW']).'.'.$_SESSION['EXT'];
$target_file = basename($_FILES["fileToUpload"]["name"]);
$target_file_main=uploadFile('uploads','plant');

if(isset($target_file) && isset($_FILES["fileToUpload"]["name"])){
	$ch = curl_init();
	$cfile = curl_file_create($target_file_main,'image/jpeg','testpic'); //replace esca.jpg with uploaded filename
	$data=array("image"=>$cfile);
	curl_setopt($ch, CURLOPT_URL, 'http://167.71.227.193:5000/predict');//ngrok is a tunnel to my machine
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$response = curl_exec($ch);
 	echo "<div id=rsp style='display:none;'>";echo $response;
 	//echo "<div id=jsr>";echo $response; echo "</div>"; 
	//echo "<script>
	//var jResp=".$response."
	
	//document.getElementById('jsr').innerHTML=jResp;
	//jso=JSON.parse(jResp); </script>";
	//REDIS procedure

}
//'{ "Pepper,_Bell___Bacterial_Spot": 4.872653789789183e-06, "Pepper,_Bell___Healthy": 2.5014212923224477e-08, "Tomato___Early_Blight": 1.5270050823801284e-07, "Tomato___Tomato_Yellow_Leaf_Curl_Virus": 0.999994993209838}'
}
?>
