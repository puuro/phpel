<?php

function save_elementti($vars){	
	global $PREFIX;
	global $mysqli;
	if($_SESSION['taso']==2){
	$id=$vars["id"];
	$nimi_upper=$vars["nimi"];
	$sisalto=$vars["sisalto"];
	$sivu=$vars["sivu"];
	$kuvaus=$vars["kuvaus"];
	$nakyva=$vars["nakyva"];
	$nimi=strtolower($vars["nimi"]);
	if($id==0){
		$mysqli->query("INSERT INTO ".$PREFIX."elementit(nimi, nimi_upper, sisalto, sivu, kuvaus, nakyva) VALUES('".$nimi."', '".$nimi_upper."', '".$sisalto."', ".$sivu.", '".$kuvaus."', ".$nakyva.")") or die("Virhe1 elementti:sql");
	}
	else {
		$mysqli->query("UPDATE ".$PREFIX."elementit SET nimi='".$nimi."', nimi_upper='".$nimi_upper."', sisalto='".$sisalto."', sivu=".$sivu.", kuvaus='".$kuvaus."', nakyva=".$nakyva." WHERE id=".$id) or die("Virhe2 elementti:sql");
	}
	}
	else {
		$id=$vars["id"];
		$sisalto=$vars["sisalto"];
		if(get_col("nakyva","elementit",$id)==1){
			$mysqli->query("UPDATE ".$PREFIX."elementit SET sisalto='".$sisalto."' WHERE id=".$id) or die("Virhe2 elementti:sql");
		}
		else{
			echo "No onkos tullut kesä nyt talven keskelle";
			exit();
		}

	}
}
?>
