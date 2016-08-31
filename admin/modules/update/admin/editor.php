<?php
include "check_auth.php";
echo "<div id='sivut'>";
//if(isset($_GET['action']) && $_GET['action']=="renode");
echo print_sivut();
echo "</div>";
echo "<div id='tools'>";
	if(isset($_GET['q'])){
		
		include "modules/".$_GET['q']."/index.php";
	}
	else {
		include "tools.php";
	}
	echo "</div>";

function print_sivut(){
	global $mysqli;
	global $PREFIX;

	echo "<h3>Sivut</h3>";
	$sivut=get_table_order("sivut","jarjestys", "asc");
	if($sivut->num_rows>0)
	while($row=$sivut->fetch_assoc()){
		echo "<p>";
		echo "<b>".$row['kuvaus']."</b>";
		if($_SESSION['taso']==2){
			echo "<a class='edit' href='index.php?q=sivu&id=".$row['id']."'>+</a>";
			echo "<a class='edit' href='index.php?action=del_sivu&id=".$row['id']."'>-</a>";
		}
		echo "</p>";
		$taso=0;
		$result=$mysqli->query("SELECT rivi_id FROM ".$PREFIX."meta WHERE top=0 AND sivu=".$row['id']);
		if($result->num_rows==1){			
			$meta=$result->fetch_assoc();
			//print_children($row['id'], $meta['rivi_id']);
			print_children($row['id'], 0);
		}
		else{
			echo "Problem with meta.";
			//exit();
		}
	}
	if($_SESSION['taso']==2){
		echo "<a class='edit' href='index.php?q=sivu'>+</a>";
	}
}
function print_children($page, $top){
	global $mysqli;
	global $taso;
	global $PREFIX;
	
	$taso++;
	$meta=$mysqli->query("SELECT * FROM ".$PREFIX."meta WHERE top=".$top." AND sivu=".$page);
	if($meta->num_rows > 0){
	
	while($row=$meta->fetch_assoc()){
		$id=$row['id'];
		$el=get_row("elementit", $id);
		//echo $el['nimi_upper'];
		if($_SESSION['taso']==2 || $el['nakyva']==1){

			if($_SESSION['taso']==2){
				$nimi=$el['nimi_upper'];
			} else{
				$nimi=$el['kuvaus'];
			}
			if($_SESSION['taso']==1) $margin=20;
			else $margin=$taso*20;
			echo "<p style='margin-left:".($margin)."px;'>";	
			echo "<span style='";
			if($el['nakyva']==1)
				echo "background-color:gold;";
			if($el['sivu']==0)
				echo "color:#555555;";
			echo "'>";
			echo $nimi;
			echo "<a class='edit' href='index.php?q=elementti&id=".$id."'>+</a>";
			echo "</span>";
			echo "</p>";
		}
		print_children($page, $row['rivi_id']);
	}
		//echo "<div style='margin-left:".($taso*20)."px;'><a href='index.php?q=elementti&top=".$id."'>+</a></div>";
	}
	$taso--;
}
?>
