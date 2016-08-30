<?php

//function save_page($id, $nimi, $vanhempi, $root, $julkinen){
function save_kayttaja($vars){
	global $PREFIX;
	global $mysqli;
	$id=$vars["id"];
	$nimi_upper=$vars["nimi"];
	$taso=$vars["taso"];
	$salasana1=$vars["salasana1"];
	$salasana2=$vars["salasana2"];
	$nimi=strtolower($vars["nimi"]);
	if($salasana1!=$salasana2){
		echo "Kentissä oli eri salasana.";
		exit();
	}

	if($id==0){
		$mysqli->query("INSERT INTO ".$PREFIX."kayttajat(nimi, taso, sala, nimi_upper) VALUES('".$nimi."', ".$taso.", '".md5($salasana1)."', '".$nimi_upper."')") or die("Virhe1 kayttaja:sql");
	}
	else {
		$mysqli->query("UPDATE ".$PREFIX."kayttajat SET nimi='".$nimi."', taso=".$taso.", nimi_upper='".$nimi_upper."' WHERE id=".$id) or die("Virhe2 kayttaja:sql");
	}
}
?>
