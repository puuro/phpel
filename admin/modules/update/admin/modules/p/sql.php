<?php
function p_get_pages(){
	global $PREFIX;
	global $mysqli;

	$result=$mysqli->query("SELECT kuvaus, nimi FROM ".$PREFIX."sivut WHERE vanhempi=0 AND julkinen=1 AND kaytossa=1");
	return $result;
}

?>
