Luodaan html-filejä...<br>
<?php
include "modules/create/sql.php";
//looppaa sivut
//jokaisella sivulla printtaa root elementin sisalto
//shell_exec("rm ../*.html");
if(isset($_GET['aa'])){
	$aa=$_GET['aa'];
	if($aa=="testi"){
		$listfile="files.test";
		$filedir="testi/";
		$test=true;
	}
	if($aa=="tosi"){
		$listfile="files.list";
		$filedir="../";
		$test=false;
	}
}
else {
	echo "Bad request";
	exit();
}
$filelist=file_get_contents($listfile);
$filelist=explode(",", $filelist);
for($i=count($filelist)-2;$i>=0;$i--){
	$file=$filelist[$i];
	if($file=="admin" || $file=="admin/"){
		echo "<b>".$file."</b>";
		exit();
	}	
	delete_file($file);
}
file_put_contents($listfile, "");
print_children_of(0);
function print_children_of($parent){
	global $mysqli;	
	global $test;
	global $filedir;
	global $listfile;
	
    //$result=get_pages_by_parent($parent, $test);
    $result=get_pages_by_parent_order($parent, "jarjestys", "asc", $test);
	while($row=$result->fetch_assoc()){
		$filename=$row['nimi'];
		$parts=explode("/", $filename);	
		if(count($parts)>1){
			if($parts[0]=="admin"){
				echo $filename."<br>";	
				echo "admin/ kansioon ei saa panna tiedostoja.";
				exit();
			}
			for($i=0;$i<count($parts)-1;$i++){
				$newdir=$filedir.$parts[$i];
				create_dir($newdir, $listfile);
			}
		}
		echo $filename."...";
		$rootname=get_col("nimi", "elementit", $row['root']);
		$sisalto=get_element_content($rootname, $row['id']);
		$newfile=$filedir.$filename;
		create_file($newfile, html_entity_decode($sisalto), $listfile);
	
		echo "OK<br>";
	}
}
function get_element_content($name, $pageid){
	global $mysqli;
	global $variables;
	global $elements;

	$sisalto=get_element_by_name($name, $pageid);
	if($sisalto=="0"){
		//echo $name." Sisältö: ".$sisalto."<br>";
		return "0";
	}
	echo "<b>".$name."</b><br>";		
	if(preg_match_all('/@"([^"]+)"/', $sisalto, $m)){
		foreach($m[1] as $match){
			$match_lower=strtolower($match);
			$parts=explode(":", $match_lower);
			if(count($parts)> 0 && count($parts)%2==0){
				for($i=0;$i<count($parts);$i=$i+2){
					if(!isset($variables[$parts[$i]])){
						$variables[$parts[$i]]=array();
					}
					$variables[$parts[$i]][]=$parts[$i+1];
					$sisalto=preg_replace('/@"'.$match.'"/', '', $sisalto,1);
				}
			}	
			else {
				echo "Huono tunniste: ".$match;
				exit();
			}
		}
	}
	
	if(preg_match_all('/##"([^"]+)"/', $sisalto, $m)){
		foreach($m[1] as $match){
			if(!isset($elements[strtolower($match)])){
				$elements[strtolower($match)]=0;
			}
			$elements[$match]++;
			$inner_text=get_element_content(strtolower($match), $pageid);
			if($inner_text=="0"){
				$inner_text=get_element_content($variables[strtolower($match)][$elements[$match]-1], $pageid);
			}
			if($inner_text=="0"){
				echo "Ei löydy elementtiä ".$match;
				exit();
			}
			$sisalto=preg_replace('/##"'.$match.'"/', $inner_text, $sisalto,1);
		}
	}
	if(preg_match_all('/!"([^"]+)"/', $sisalto, $m)){
		foreach($m[1] as $match){
			$match_lower=strtolower($match);
			$parts=explode(":", $match_lower);	
			$ok=false;
			if(count($parts)==2){
				$inner_text=get_module_content($parts, $pageid);
				$ok=true;
			}	
			$sisalto=preg_replace('/!"'.$match.'"/', $inner_text, $sisalto,1);
		}
	}
	return $sisalto;
}
function get_src_content($parts){
	$extension=$parts[1];
	if($extension =="js"){
		$inner_text="<script type='text/javascript' src='".join(".",$parts)."'></script>";
	}
	else if($extension =="css"){
		$inner_text="<link rel='stylesheet' type='text/css' href='".join(".",$parts)."'>";
	}
	else {
		echo "Huono pääte: ".$match." ".$extension;
		exit();
	}
	return $inner_text;
}
function get_module_content($parts, $pageid){
	//echo "Hep! ".$match."<br>";
	/*
	if(count($parts)!=2){
		echo "Väärä tunniste: ".$match;
		exit();
	}
	*/
	$filename="modules/".$parts[0]."/".$parts[1].".php";
	if(!is_file($filename)){
		echo "Tiedostoa ei ole: ".$filename;
		exit();
	}
	include $filename;
	return $included_content;
}

?>
