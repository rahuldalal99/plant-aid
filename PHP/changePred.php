<?php
$json='{ "Pepper,grape_Bell___Bacterial_Spot": 4.872653789789183e-06, "Pepper,_Bell___Healthy": 2.5014212923224477e-08, "GRGrape___Early_Blight": 1.5270050823801284e-07, "Tomato___Tomato_Yellow_Grape_Curl_Virus": 0.999994993209838}';
$opt='grape';
//getPred($json,$opt);
function getPred($json,$opt){               
	
	$json_t=json_decode($json,true);
		//$json_t=($json);
		$json=json_decode($json);
                $disAll=array_keys($json_t);
	//	print_r($disAll);          
		$dis=array();
		if($opt=="I don't know"){ $dis=$disAll; }
		else{
			foreach( $disAll as $d){
//				echo $d.'?'.$opt;
				if(strpos(strtolower($d),$opt)==true){
                			array_push($dis,$d);
                		}
			}
		}
//		print_r($dis);
                $max=$json_t[$dis[0]];
                $d=$dis[0];
                for($i=0;$i<count($dis);$i++){
                        if($max<$json_t[$dis[$i]]){
                        $max=$json_t[$dis[$i]];
                        $d=$dis[$i];
                        }
		}
		return $d;
}

?>
