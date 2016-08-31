<?php
//included in index
if(isset($_POST['post_elementti'])){
	if($_SESSION['taso']==2)
	$vars=array("nimi", "id", "sisalto", "sivu", "kuvaus", "nakyva");
	else
	$vars=array("sisalto", "id");
	foreach($vars as $var){
		$vars[$var]=cleanpost($var, $_POST[$var]);
	}
	include "modules/elementti/sql.php";
	save_elementti($vars);
}
if(isset($_GET['action']) && $_GET['action']=="del_elementti"){
	$id=$_GET['id'];
	if($id!="" && is_numeric($id)){
		delete_where_id("elementit", $id);
		header("location:index.php?action=renode");
		
	}
	else {
		echo "Bad id.";
		exit();
	}
}
?>
