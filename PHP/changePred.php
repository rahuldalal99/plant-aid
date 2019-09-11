<?php
$json='{ "1_Pepper,grape_Bell___Bacterial_Spot": 4.872653789789183e-06, "2_Pepper,_Bell___Healthy": 2.5014212923224477e-08, "3_Grape___Early_Blight": 1.5270050823801284e-07, "4_Tomato___Tomato_Yellow_Grape_Curl_Virus": 0.999994993209838}';
$opt='grape';
//getPred($json,$opt);
function getPred($json,$opt){               
	$opt=strtolower($opt);
	$flag=false;
	$classes_actual=array('Cercospora Leaf Spot','Common Rust','Blight', 'Black Rot','Esca','Blight','Blight', 'Blight','Bacterial Spot', 'Blight','Blight', 'Mold','Septoria Spot','Spider Mites','Target Spot');
	$json_t=json_decode($json,true);
		//$json_t=($json);
		$json=json_decode($json);
                $disAll=array_keys($json_t);
	//	print_r($disAll);          
		$dis=array();
		if($opt=="Unknown"){ $dis=$disAll; $flag=true; }
		else{
			foreach( $disAll as $d){
//				echo $d.'?'.$opt;
				if(strpos(strtolower($d),$opt)==true){
                			array_push($dis,$d);
					$flag=true;
				}
			}
		}
		if(!$flag) return "Unknown";
		else {
		//print_r($dis);
		
		$max=$json_t[$dis[0]];
		
		$d=$dis[0];
		
		for($i=0;$i<count($dis);$i++){
                        if($max<$json_t[$dis[$i]]){
                        $max=$json_t[$dis[$i]];
                        $d=$dis[$i];
                        }
		}
		try{
			$pred_idx=(int)($d[0].$d[1]);
			return $classes_actual[$pred_idx];
		}catch(Exception $exception) {
			return "Unknown";
		}
		}
}

?>
