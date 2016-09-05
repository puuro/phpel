<?php
echo_query("DELETE FROM ".$PREFIX."meta");

$result=get_table("sivut");
while($row=$result->fetch_assoc()){
	$variables=array();
	$elements=array();
	echo "<b>".$row['nimi_upper']."</b><br>";	
	crawl_element($row['root'], $row['id'], 0);
}
function crawl_element($id, $pageid, $top){
	global $PREFIX;
	global $variables;
	global $elements;

	if(get_col("sivu", "elementit", $id) == 0){
		$green=0;
	} else{
		$green=1;
	}
	
	$insert_id=echo_insert("INSERT INTO ".$PREFIX."meta(id, top, sivu, green) VALUES(".$id.", ".$top.", ".$pageid.", ".$green.")");
	$sisalto=get_col("sisalto", "elementit", $id);

	if(preg_match_all('/@"([^"]+)"/', $sisalto, $m)){
		foreach($m[1] as $match){
			$match_lower=strtolower($match);
			$parts=explode(":", $match_lower);
			if(count($parts)> 0 && count($parts)%2==0){
				for($i=0;$i<count($parts);$i=$i+2){
					if(!isset($variables[$parts[$i]])){
						$variables[$parts[$i]]=array();
					}
					$variables[$parts[$i]][]=$parts[$i+1];
					echo "Löydettiin muuttuja: ".$parts[$i].":".$parts[$i+1].". ".$parts[$i]." muuttujia ".count($variables[$parts[$i]])." kpl<br>";
				}
			}	
			else {
				echo "Huono tunniste: ".$match;
				exit();
			}
		}
	}
	
	if(preg_match_all('/##"([^"]+)"/', $sisalto, $m)){
		foreach($m[1] as $match){
			echo $match.": <br>";
			if(!isset($elements[$match])){
				$elements[$match]=0;
				echo "elements[".$match."]=0<br>";
			}
			$elements[$match]++;
			$elem_id=get_id_of(strtolower($match), $pageid);		
			if($elem_id==0){
				echo "Ei elementtiä. Etsitään muuttuja ".$match.".<br>"; 
				echo "Elem count ".$elements[$match]." <br>";
				echo "variables[".strtolower($match)."][".($elements[$match]-1)."]<br>";
				$elem_id=get_id_of($variables[strtolower($match)][$elements[$match]-1], $pageid);
				//echo "Löytyi elementti ".$get_col("kuvaus","elementit",$elem_id)."<br>";
			}
			if($elem_id==null){
				exit();
			}
			crawl_element($elem_id, $pageid, $insert_id);
			//crawl_element($elem_id, $pageid, $id);
		}
	}
}
?>
