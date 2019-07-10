<?php

echo "

<!DOCTYPE html>
<html>
<body>

<form action=\"upload.php\" method=\"post\" enctype=\"multipart/form-data\">
    Select image to upload:
    <input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\">
    <input type=\"submit\" value=\"Upload Image\" name=\"submit\">
</form>

</body>
</html>

";
//TODO: implement select list for plant leaf name;
// [ Grape , Strawberry, Potato, Tomato ]
uploadFile('uploads','plant');
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
if(isset($target_file)){
	$ch = curl_init();
	$cfile = curl_file_create($target_file,'image/jpeg','testpic'); //replace esca.jpg with uploaded filename
	$data=array("image"=>$cfile);
	curl_setopt($ch, CURLOPT_URL, 'http://autumn.ai/predict');//ngrok is a tunnel to my machine
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$response = curl_exec($ch);
	print("response");
	echo("<div id =jso type=hidden>$response<div>");
	echo("<script>	
	jso=document.getElementById('jso');
	if(jso!=null){
		alert(jso.firstChild);
		jso=JSON.parse(jso.firstChild.textContent);
		alert(jso);
	}
</script>");
	//REDIS procedure
}

//'{ "Pepper,_Bell___Bacterial_Spot": 4.872653789789183e-06, "Pepper,_Bell___Healthy": 2.5014212923224477e-08, "Tomato___Early_Blight": 1.5270050823801284e-07, "Tomato___Tomato_Yellow_Leaf_Curl_Virus": 0.999994993209838}'
?>
