<?php
function get_element_by_name($name, $pageid){
	global $PREFIX;
	global $mysqli;

	$result=$mysqli->query("SELECT * FROM ".$PREFIX."elementit WHERE nimi='".$name."' ORDER BY sivu DESC");
	//if($result->num_rows == 0){
		//echo "'".$name."': ei löytynyt.";
		//return;
	//}
	while($row=$result->fetch_assoc()){
		if($row['sivu']== $pageid || $row['sivu']==0){
			return $row['sisalto'];
		}
	}
	return "0";
}
function get_pages_by_parent($parent, $test){
	global $mysqli;
	global $PREFIX;
	
	if(!$test)
	$result=$mysqli->query("SELECT * FROM ".$PREFIX."sivut WHERE vanhempi=".$parent." AND kaytossa=1 AND julkinen=1");
	else if($test)
	$result=$mysqli->query("SELECT * FROM ".$PREFIX."sivut WHERE vanhempi=".$parent." AND kaytossa=1");
	if($result->num_rows==0){
		echo "Ei sivuja.<br>";
		exit();
	}	
	else return $result;
}
    
    function get_pages_by_parent_order($parent, $order, $direction){
        global $mysqli;
        global $PREFIX;
        
		if(!$test)
        $result=$mysqli->query("SELECT * FROM ".$PREFIX."sivut WHERE vanhempi=".$parent." AND kaytossa=1 AND julkinen=1 ORDER BY ".$order." ".$direction);
		else if($test)
        $result=$mysqli->query("SELECT * FROM ".$PREFIX."sivut WHERE vanhempi=".$parent." AND kaytossa=1 ORDER BY ".$order." ".$direction);
        if($result->num_rows==0){
            echo "Ei sivuja.<br>";
            exit();
        }	
        else return $result;
    }


?>
