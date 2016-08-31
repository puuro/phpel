<?php

//function save_page($id, $nimi, $vanhempi, $root, $julkinen){
function save_page($vars){
	global $PREFIX;	
	global $mysqli;
	$id=$vars["id"];
	$nimi_upper=$vars["nimi"];
	$vanhempi=$vars["vanhempi"];
	$root=$vars["root"];
	$julkinen=$vars["julkinen"];
    $kaytossa=$vars["kaytossa"];
    $jarjestys=$vars["jarjestys"];
	$kuvaus=$vars["kuvaus"];
	$nimi=strtolower($vars["nimi"]);
	if($root==0){
		$mysqli->query("INSERT INTO ".$PREFIX."elementit(nimi, nimi_upper, kuvaus, sisalto, sivu, nakyva) VALUES('uusi', 'Uusi', 'Uusi elementti', '', 0, 0)") or die("Virhe0 sivu:sql");
		$root=$mysqli->insert_id;
	}

	if($id==0){
		$mysqli->query("INSERT INTO ".$PREFIX."sivut(nimi, vanhempi, root, julkinen, nimi_upper, kuvaus, kaytossa, jarjestys) VALUES('".$nimi."', ".$vanhempi.", ".$root.", ".$julkinen.",'".$nimi_upper."', '".$kuvaus."', ".$kaytossa.", ".$jarjestys.")") or die("Virhe1 sivu:sql");
	}
	else {
		$mysqli->query("UPDATE ".$PREFIX."sivut SET nimi='".$nimi."', vanhempi=".$vanhempi.", root=".$root.", julkinen=".$julkinen.", nimi_upper='".$nimi_upper."', kuvaus='".$kuvaus."', kaytossa=".$kaytossa.", jarjestys=".$jarjestys." WHERE id=".$id) or die("Virhe2 sivu:sql");
	}
}
?>
