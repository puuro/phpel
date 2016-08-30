<?php
include "check_auth.php";

function get_mysqli(){
	$HOST="localhost";
	$USER="root";
	$PASS="kakka";
	$DATA="eki_cms";

	$mysqli =new mysqli($HOST, $USER, $PASS, $DATA);
	$mysqli->query("SET NAMES utf8");
	return $mysqli;
}
function get_id_of($name, $pageid){
	global $PREFIX;
	global $mysqli;

	$result=$mysqli->query("SELECT sivu, id FROM ".$PREFIX."elementit WHERE nimi='".$name."' ORDER BY sivu DESC");
	while($row=$result->fetch_assoc()){
		if($row['sivu']== $pageid || $row['sivu']==0){
			return $row['id'];
		}
	}
	return 0;
}
function get_table($table){
	global $PREFIX;
	global $mysqli;
	
	$table=$mysqli->real_escape_string($table);
	$result=$mysqli->query("SELECT * FROM ".$PREFIX.$table);
	return $result;
}
function get_table_order($table, $order, $direction){
	global $PREFIX;
	global $mysqli;
	
	$table=$mysqli->real_escape_string($table);
	$result=$mysqli->query("SELECT * FROM ".$PREFIX.$table." ORDER BY ".$order." ".$direction);
	return $result;
}
function get_row($table, $id){
	global $PREFIX;
	global $mysqli;
	
	$table=$mysqli->real_escape_string($table);
	$id=$mysqli->real_escape_string($id);
	$result=$mysqli->query("SELECT * FROM ".$PREFIX.$table." WHERE id=".$id);
	if($result->num_rows==1){
		$row=$result->fetch_assoc();
	} else{
		print_error("row !1");
	}
	return $row;
}
function get_col($col, $table, $id){
	global $PREFIX;
	global $mysqli;

	$col=$mysqli->real_escape_string($col);
	$table=$mysqli->real_escape_string($table);
	$id=$mysqli->real_escape_string($id);
	$result=$mysqli->query("SELECT ".$col." FROM ".$PREFIX.$table." WHERE id=".$id);
	if($result->num_rows==1){
		$row=$result->fetch_assoc();
		return $row[$col];
	}
	else print_error("get col");
}
function delete_where_id($table, $id){
	global $PREFIX;
	global $mysqli;
	$table=$mysqli->real_escape_string($table);
	$id=$mysqli->real_escape_string($id);
	if(!$mysqli->query("DELETE FROM ".$PREFIX.$table." WHERE id=".$id))
		print_error("del ".$table);
}
function echo_insert($query){
	global $PREFIX;
	global $mysqli;
	//echo $query."->";
	$result=$mysqli->query($query) or die("Virhe");
	//echo "OK<br>";
	return $mysqli->insert_id;
}
function echo_query($query){
	global $PREFIX;
	global $mysqli;
	//echo $query."->";
	$result=$mysqli->query($query) or die("Virhe");
	//echo "OK<br>";
	return $result;
}
function print_error($str){
	echo $str;
	exit();
}
?>
