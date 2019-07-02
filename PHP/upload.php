<?php
//Working
//TODO: save file from requests by arbitrary ID, and use that ID below
$ch = curl_init();
$cfile = curl_file_create('esca.jpg','image/jpeg','testpic'); //replace esca.jpg with uploaded filename
$data=array("image"=>$cfile);

curl_setopt($ch, CURLOPT_URL, 'http://5e82856a.ngrok.io/predict');//ngrok is a tunnel to my machine
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($ch);
print_r($response);
?>
