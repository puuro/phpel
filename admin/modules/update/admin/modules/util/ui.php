<?php
include "check_auth.php";
function start_table(){
	return "<table>";
}
function end_table(){
	return "</table>";
}
function start_form($action, $method, $onkeyup=false){
	echo "<br>";
	$form="";
	$form.="<form action='".$action."' method='".$method."'";
	if($onkeyup){
		$form.=" onkeyup='form_update()'";
	}
	$form.=">";
	return $form;
}
function end_form(){
	return "</form>";
}
function table_row($array){
	if(count($array)>0){
		$str="";
		$str.="<tr>";
		foreach($array as $td){
			$str.="<td>".$td."</td>";
		}
		$str.="</tr>";
	}
	else $str="<tr></tr>";
	return $str;
}
function table_headers($array){
	if(count($array)>0){
		$str="";
		$str.="<tr>";
		foreach($array as $td){
			$str.="<th>".$td."</th>";
		}
		$str.="</tr>";
	}
	else $str="<tr></tr>";
	return $str;
}
function print_table($table, $cols, $module){
	global $mysqli;
	$str="";
	$result=get_table($table);
	if($result->num_rows>0){
		$headers=array();
		foreach	($cols as $col){
			$parts=explode(":", $col);
			if(count($parts)==3){
				$headers[]=$parts[0];
			}
			else $headers[]=$col;
		}
		$str.= start_table();
		$str.= table_headers($headers);
		while($row=$result->fetch_assoc()){
			
			$td=array();
			foreach($cols as $col){
				$parts=explode(":", $col);
				if(count($parts)==3){
					if($row[$parts[0]]==0)
						$td[]="0";
					else 
						$td[]=htmlentities(substr(get_col($parts[2], $parts[1], $row[$parts[0]]), 0, 20));
				}
				else 
					$td[]=htmlentities(substr($row[$col],0,20));
			}
			$td[]="<a class='edit' href='index.php?q=".$module."&id=".$row['id']."'>+</a>";
			$td[]="<a class='edit' href='index.php?action=del_".$module."&id=".$row['id']."'>-</a>";
			$str.= table_row($td);	
		}
		$str.= end_table();
	}
	else $str=$table.": tyhjä<br>";
	$str.="<a class='edit' href='index.php?q=".$module."'>+</a>";
	return $str;
}
function print_textrow($header, $name, $value, $edit){
?>
	<tr>
	<td><?=$header?></td>
	<td><input type="text" id="<?=$name?>" name="<?=$name?>" value="<?=$value?>" <?php echo ($edit ? "" : "readonly"); ?>></td>
	</tr>
<?php
}
function print_passrow($header, $name, $value, $edit){
?>
	<tr>
	<td><?=$header?></td>
	<td><input type="password" id="<?=$name?>" name="<?=$name?>" value="<?=$value?>" <?php echo ($edit ? "" : "readonly"); ?>></td>
	</tr>
<?php
}
function print_textarearow($header, $name, $value){
?>
	<tr>
	<td><?=$header?><div id="merkki"></div></td>
	<td><div id="ace"><?=$value?></div></td>
	</tr>
	<input id="textarea1" type="hidden" name="<?=$name?>" value="<?=$value?>">
<?php
}
function print_checkrow($header, $name, $bool){
?>
	<tr>
	<td><?=$header?></td>
	<td>
		<input type="hidden"   					name="<?=$name?>" value="0">	
		<input type="checkbox" id="<?=$name?>"  name="<?=$name?>" value="1" <?php echo ($bool ? "checked" : "") ?>>
	</td>
	</tr>
<?php
}
function print_optionrow($header, $list_id, $list_nimi, $name, $select){
?>
	<tr>
	<td><?=$header?></td>
	<td>
	<select name="<?=$name?>">
	<?php
	for($i=0;$i<count($list_id);$i++){
		echo "	<option value='".$list_id[$i]."' ";
		if($list_id[$i]==$select)
			echo "selected";
		echo ">".$list_nimi[$i]."</option>";
	}
	?>
	</select>
	</td>
	</tr>
<?php
}
function print_submitrow($identifier, $val){
?>
<tr>
<td><input type="text" name="<?=$identifier?>" value="1" style="display:none;"></td>
<td><input id="submit" type="submit" value="<?= $val ?>" ></td>
</tr>
<?php
}
function indexlink(){
	return "<a href='index.php'>Etusivu</a>";
}






?>
