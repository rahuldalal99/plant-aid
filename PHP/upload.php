


<?php
//TODO initialise $_SESSION['email'] wherever $_SESSION['userid'] is initialised 
//require
session_start();
require 'login/header.php'; //NAV bar
require 'login/includes/dbh.inc.php';
echo "<link rel='stylesheet'  href='login/styles.css'>";
if(!isset($_SESSION['userid'])){
	header("Location: http://medivine.me:420/index.php?error=notsignedin");
	exit();
}
echo "<div class='container'>";
echo "<div class=\"row justify-content-center\" style=\" font-size:xx-large \">";
echo "Welcome " . $_SESSION['userid'];
//$_SESSION['email']=$_POST['email_id'];//from login.php or signup.php
echo "</div>";//end div for row justify-content-center
require('changePred.php');

require('utility.php');
$dis_arr = json_decode(file_get_contents('array.txt'), true);

$classes_actual=array('Cercospora Leaf Spot','Common Rust','Blight', 'Black Rot','Esca','Blight','Blight', 'Blight','Bacterial Spot', 'Blight','Blight', 'Mold','Septoria Spot','Spider Mites','Target Spot');


echo "

<!DOCTYPE html>
<html>
<body>
<div id=image-div style='max-height:300px; max-width:300px;' >
</div>
<form action='upload.php'  method='post' enctype='multipart/form-data'>
 <div class='row justify-content-center'>
  	<div class='col-md-6 col-lg-6 col-xs-3'>
    		Select image to upload:
   		<select name=\"plant\">";
			for($i=0;$i<count($dis_arr);$i++){
			echo "<option class='btn primary'>".$dis_arr[$i]."</option>";
			}			
echo "</select></div> <!--COL END-->
	<br></div> <!--ROW END-->
	<br> <br>
	<div class='row content-justify-center'>
		<div class='col-md-6 text-center'>
    <input type=\"file\" class='btn btn-outline-secondary' name=\"fileToUpload\" id=\"fileToUpload\" >
<!--	<input type='button' value='browse' onclick='document.getElementById(\"fileToUpload\").click()'> -->
		 </div> <!--div col-->
		<div class='col-md-6 text-center'>
    <input type=\"submit\" class='btn btn-outline-secondary'  value=\"Upload Image\" name=\"submit\">
	</div> 
	<!--div column-->

 </div> <!--ROW END-->
    <!--Removed 1 extra div here -->
</form>

";
if(isset($_FILES['fileToUpload'])){
	/*
	 * TODO: insertIntoDB($_SESSION['email'].$_SESSION['DATE_NOW'].$_SESSION['TIME_NOW']).'];
	 *   email_id | image_path | prediction | date_upload 
	 *     ----------+------------+------------+-------------
	 *     */
	$target_file = basename($_FILES["fileToUpload"]["name"]);
	$target_file_main=uploadFile('uploads','plant');
	

	$opt=$_POST['plant'];	
	$_SESSION['plant']=$opt;


	if(isset($target_file) && isset($_FILES["fileToUpload"]["name"])){
		        $ch = curl_init();
			        $cfile = curl_file_create($target_file_main,'image/jpeg','testpic'); //replace esca.jpg with uploaded filename
			        $data=array("image"=>$cfile);
				        curl_setopt($ch, CURLOPT_URL, 'http://medivine.me:5000/predict');//ngrok is a tunnel to my machine
				        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
					        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						echo "<div class=' jumbotron row justify-content-center'>";
					        $response = curl_exec($ch);
						        echo "<div id=rsp' style=display:none; >";echo $response;
						        //include('response.php');
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
							//print_r($_SESSION);
							if($opt!="Unknown"){
								$pred=getPred($response,$opt);
								$_SESSION['disease']=$pred;
								echo "</div><a href='cure.php'>
									<div style='color:black;'; >Prediction:".$pred;
							}else{
								$p1 = explode("_",$pred);
								echo "</div><a href='cure.php'> 
									<div style='color:black;'; >Prediction:";
								$tv=0;
								$plant="";
								$pred="";	
								foreach($p1 as $i){
								//	echo $i . " ";
									if($tv>0){
										echo $i . " ";
										
									}
									if($tv==1){
										$plant=$i;
									}
									if($tv>1){

										$pred.=$i;
									}
									$tv+=1;
								}
								$_SESSION['plant']=$plant;
								$_SESSION['disease']=$pred;
							}	
							$sql ="insert into user_images values('$email','$fPath','$pred','$dn', '$tn')";
							
							$res = pg_query($dbconn,$sql);
						/*	$p1 = explode("_",$pred);				
							echo "</div>
								<a href='cure.php'> <div style='color:black;'; >Prediction:";
							foreach($p1 as $i){
								echo $i . " ";
							}
						 */	
							echo	"</div></a><!--Jumbotron div end--> </div><!--Column div end--> </div> <!--Row div end--> 
								</div> 
								</body>
								</html> ";//End echo
							if(!$res){
								echo "Cannot insert image into DB " . pg_last_error();
							}					
						
											
	}
	/*'{ "Pepper,_Bell___Bacterial_Spot": 4.872653789789183e-06, "Pepper,_Bell___Healthy": 2.5014212923224477e-08, "Tomato___Early_Blight": 1.5270050823801284e-07, "Tomato___Tomato_Yellow_Leaf_Curl_Virus": 0.999994993209838}'
	 * */
}
?>
