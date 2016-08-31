<?php
include "check_auth.php";
$blocks=array();
$links=array();
$modules=array();
$modules[]="sql";
$modules[]="util";
$modules[]="elementti";
if($_SESSION['taso']==2){
	$modules[]="sivu";
	$modules[]="kayttaja";
}
$modules_list=file_get_contents("include.list");
$modules_=explode(",", $modules_list);
foreach($modules_ as $module){
	$modules[]=trim($module);
}
echo "<div style='float:right;font-family:\"Courier New\";'>";
foreach($modules as $module){
	//echo "modules/".$module."/module.php";
	
	include "modules/".$module."/module.php";
	//echo " included<br>";
}
echo "</div>";

?>
