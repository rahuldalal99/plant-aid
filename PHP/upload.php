


<?php
//TODO initialise $_SESSION['email'] wherever $_SESSION['userid'] is initialised 
//require
session_start();
require 'login/header.php'; //NAV bar
require 'login/includes/dbh.inc.php';
echo "<link rel='stylesheet'  href='login/styles.css'>;";
if(!isset($_SESSION['userid'])){
	header("Location: http://167.71.227.193:420/login/index.php?error=kbye");
	exit();
}
echo "welcome " . $_SESSION['userid'];
//$_SESSION['email']=$_POST['email_id'];//from login.php or signup.php


require('utility.php');
$dis_arr = json_decode(file_get_contents('array.txt'), true);

echo "

<!DOCTYPE html>
<html>
<body>
<div id=image-div>
</div>
<form action=\"upload.php\" method=\"post\" enctype=\"multipart/form-data\">
    Select image to upload:";
 /*   <select>";
for($i=0;$i<count($dis_arr);$i++){
	echo "<option>".$dis_arr[$i]."</option>";
}
echo"
    </select><br>*/
echo"
    <input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\">
    <input type=\"submit\" value=\"Upload Image\" name=\"submit\">
</form>
   <script>
        i=0;
        function getPred(){               
                var elem=document.getElementById('rsp').innerText;
                var json=JSON.parse(elem);
                disAll=Object.keys(json);
                dis=[];
		var opt_n=document.getElementsByTagName('select')[0].selectedIndex;
		var opt=document.getElementsByTagName('select')[0][opt_n].value;
		if(opt==\"I don't know\"){ dis=disAll; }
		else{
		for(d in disAll){
                	if(disAll[d].toLowerCase().includes(opt)){
                		dis.push(disAll[d]);
                	}
		}
		}
                max=json[dis[0]];
                d=dis[0];
                for(i=0;i<dis.length;i++){
                        if(max<json[dis[i]]){
                        max=json[dis[i]]
                        d=dis[i];
                        }
		}
		
		document.getElementById('result').innerText=d;
       }
        </script>
</body>
</html>

";
if(isset($_FILES['fileToUpload'])){
	/*
	 * TODO: insertIntoDB($_SESSION['email'].$_SESSION['DATE_NOW'].$_SESSION['TIME_NOW']).'];
	 *   email_id | image_path | prediction | date_upload 
	 *     ----------+------------+------------+-------------
	 *     */
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
						        include('response.php');
						//	str_replace("[","{",$response);
						//	str_replace("]","}",$response);	
							$jresp=json_decode($response,true);
							arsort($jresp);	
							foreach($jresp as $key=>$value){
								$pred=$key;
								break;	
							}
							echo $pred;
							//Problem is occuring because $dn is not in required format .
							$dn = date('d-m-Y');
							$email=$_SESSION['email'];
							$tn = date('h-i-s');
							$fPath=$_SESSION['fPath'];
							print_r($_SESSION);
							$sql ="insert into user_images values('$email','$fPath','$pred','$dn', '$tn')";
							$res = pg_query($dbconn,$sql);	#NEED HELP
							if(!$res){
								echo "Cannot insert image into DB " . pg_last_error();
							}					
						
											
	}
	/*'{ "Pepper,_Bell___Bacterial_Spot": 4.872653789789183e-06, "Pepper,_Bell___Healthy": 2.5014212923224477e-08, "Tomato___Early_Blight": 1.5270050823801284e-07, "Tomato___Tomato_Yellow_Leaf_Curl_Virus": 0.999994993209838}'
	 * */
}
?>
