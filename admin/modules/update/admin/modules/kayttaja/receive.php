<?php
//included in index
if(isset($_POST['post_kayttaja']) && $_SESSION['taso']==2){
	$vars=array("nimi", "id", "taso", "salasana1", "salasana2");
	foreach($vars as $var){
		$vars[$var]=cleanpost($var, $_POST[$var]);
	}
	include "modules/kayttaja/sql.php";
	save_kayttaja($vars);
}
if(!isset($mysqli)){
	echo "ei mysqli";
	exit();
}

?>
