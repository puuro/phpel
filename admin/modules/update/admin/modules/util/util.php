<?php
function cleanpost($varname, $var){
	global $mysqli;	

	if($var==""){
		echo "Tyhjä muuttuja(".$varname.")";
		exit();
	}
	return $mysqli->real_escape_string($var);
}
function get_option_array($table, $col, $array){
	$list_id	=array();
	$list_col	=array();
	for($i=0;$i<count($array);$i++){
		$list_id[]=$array[$i]["id"];
		$list_col[]=$array[$i]["col"];
	}
	$result=get_table($table);
	if($result->num_rows>0){
	while($row=$result->fetch_assoc()){
		$list_id[]=$row['id'];
		$list_col[]=$row[$col];
	}
	}
	return array("id"=>$list_id, "col"=>$list_col);
}
function delete_file($file){
	if(is_dir($file)){
		if(rmdir($file)){
			echo "rmdir ".$file."<br>";
		}
		else{
			echo "rmdir ".$file." virhe<br>";
		}
	}
	if(is_file($file)){
		if(unlink($file)){
			echo "unlink ".$file."<br>";
		}
		else{
			echo "unlink ".$file." virhe<br>";
		}
	}
}
function create_file($newfile, $sisalto, $listfile){
	file_put_contents($newfile, $sisalto);
	file_put_contents($listfile, $newfile.",", FILE_APPEND);
	chmod($newfile, 0755);

}
function create_dir($newdir, $listfile){
	if(!is_dir($newdir))
		if(mkdir($newdir, 0755)){
			echo "mkdir ".$newdir."<br>";
		}
		else {
			echo "mkdir ".$newdir." virhe.";
			exit();
		}
	file_put_contents($listfile, $newdir.",", FILE_APPEND);

}
function get_dotdir($pageid){
	$page_nimi=get_col("nimi", "sivut", $pageid);
	$parts=explode("/", $page_nimi);
	if(!$parts){
		echo "p:css explode virhe sivulla '".$page_nimi."'";
		exit();
	}
	$dotdir="";
	for($i=0;$i<count($parts)-1;$i++){
		$dotdir.="../";
	}
	return $dotdir;
}
?>
