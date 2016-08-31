<?php
	$new=false;
	if(isset($_GET['id'])){
		$id=$mysqli->real_escape_string($_GET['id']);
		$row=get_row("kayttajat", $id);	
		$nimi=$row['nimi_upper'];
		$taso=$row['taso'];
		$salasana="salasana";
	}	
	else{
		$new=true;
		$nimi="";
		$id="0";
		$taso="1";
		$salasana="";
	}

	echo start_form("index.php", "post");
	echo start_table();
	print_textrow("ID", "id", $id, false);
	print_textrow("Käyttäjätunnus", "nimi", $nimi, true);
	print_passrow("Salasana", "salasana1", $salasana, $new);
	print_passrow("Salasana", "salasana2", $salasana, $new);
	print_optionrow("Taso", array("1", "2"), array("1", "2"), "taso", $taso);
	print_submitrow("post_kayttaja", "OK");
	echo end_table();
	echo end_form();
		
?>
