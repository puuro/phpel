<?php
include_once "modules/p/sql.php";
$result=p_get_pages();
$html="";
$html.="<div class='p_menu'>";
while($row=$result->fetch_assoc()){
	$html.="<a class='p_menu' href='".$row['nimi']."'>".$row['kuvaus']."</a>";
}
$html.="</div>";
$included_content=$html;
?>
