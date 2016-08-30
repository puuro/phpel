<?php
	if($_SESSION['taso']!=2){
		echo "Permission denied.";
		exit();
	}
	if(isset($_GET['id'])){
		$sivu_id=$mysqli->real_escape_string($_GET['id']);
		$sivu_row=get_row("sivut", $sivu_id);
		$sivu_id=$sivu_row['id'];
		$sivu_nimi=$sivu_row['nimi_upper'];
		$sivu_vanhempi=$sivu_row['vanhempi'];
		$sivu_root=$sivu_row['root'];
        $sivu_julkinen=$sivu_row['julkinen'];
        $sivu_jarjestys=$sivu_row['jarjestys'];
		$sivu_kuvaus=$sivu_row['kuvaus'];
		$sivu_kaytossa=$sivu_row['kaytossa'];
	}
	else{
		$sivu_id="0";
		$sivu_nimi="";
		$sivu_vanhempi="";
		$sivu_root="";
		$sivu_julkinen="1";
		$sivu_kuvaus="";
		$sivu_kaytossa="1";
	}
	$addition=array(array("id"=>0,"col"=>"[master]"));	
	$list_sivu=get_option_array("sivut", "nimi_upper", $addition);
	$addition=array(array("id"=>0,"col"=>"[Uusi elementti]"));	
	$list_elem=get_option_array("elementit", "nimi_upper", $addition);

	echo start_form("index.php", "post");
	echo start_table();
	print_textrow("ID", "id", $sivu_id, false);
	print_textrow("Tiedostonimi", "nimi", $sivu_nimi, true);
	print_textrow("Otsikko", "kuvaus", $sivu_kuvaus, true);
	print_optionrow("Vanhempi", $list_sivu["id"], $list_sivu["col"], "vanhempi", $sivu_vanhempi);
	print_optionrow("Elementti", $list_elem["id"], $list_elem["col"], "root", $sivu_root);
	print_checkrow("Julkinen", "julkinen", $sivu_julkinen);
    print_checkrow("Käytössä", "kaytossa", $sivu_kaytossa);
    print_textrow("Järjestys", "jarjestys", $sivu_jarjestys, true);
	print_submitrow("post_sivu", "OK");
	echo end_table();
	echo end_form();
		
?>
