<?php
//included in index
if(isset($_POST['post_sivu']) && $_SESSION['taso']==2){
	$vars=array("nimi", "id", "vanhempi", "root", "julkinen", "kuvaus", "kaytossa", "jarjestys");
	foreach($vars as $var){
		$vars[$var]=cleanpost($var, $_POST[$var]);
	}
	include "modules/sivu/sql.php";
	save_page($vars);
}
if(isset($_GET['action']) && $_GET['action']=="del_sivu" && $_SESSION['taso']==2){
	$id=$_GET['id'];
	if($id!="" && is_numeric($id)){
		$result=$mysqli->query("SELECT id, nimi_upper FROM elementit WHERE sivu=".$id);
		if($result->num_rows > 0){
		echo "Ei voitu poistaa sivua: poista ensin sivuun kuuluvat elementit<br>";
		while($row=$result->fetch_assoc()){
			echo "'".$row['nimi_upper']."'<br>";	
			exit();
		}
		}	
		delete_where_id("sivut", $id);
		header("location:index.php?action=renode");
	}
	else {
		echo "Bad id.";
		exit();
	}
}

?>
