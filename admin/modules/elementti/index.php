<?php
if($_SESSION['taso']==2){
	if(isset($_GET['id'])){
		$elem_id=$mysqli->real_escape_string($_GET['id']);
		$elem_row=get_row("elementit", $elem_id);
		$elem_id=$elem_row['id'];
		$elem_nimi=$elem_row['nimi_upper'];
		$elem_sisalto=$elem_row['sisalto'];
		$elem_sivu=$elem_row['sivu'];
		$elem_kuvaus=$elem_row['kuvaus'];
		$elem_nakyva=$elem_row['nakyva'];
	}
	else{
		$elem_id="0";
		$elem_nimi="";
		$elem_sisalto="";
		$elem_sivu="";
		$elem_kuvaus="";
		$elem_nakyva="";
	}
	$addition=array(array("id"=>0,"col"=>"[Ei mikään]"));	
	$list=get_option_array("sivut", "kuvaus", $addition);
	echo start_form("index.php", "post", true);
	echo start_form("index.php", "post");
	echo start_table();
	print_textrow("ID", "id", $elem_id, false);
	print_textrow("Nimi", "nimi", $elem_nimi, true);
	print_textrow("Kuvaus", "kuvaus", $elem_kuvaus, true);
	print_textarearow("Sisältö", "sisalto", htmlentities($elem_sisalto));
	print_optionrow("Sivu", $list["id"], $list["col"], "sivu", $elem_sivu);
	print_optionrow("Näkyvä", array("0", "1"), array("Ei", "On"), "nakyva", $elem_nakyva);
	print_submitrow("post_elementti", "OK");
	echo end_table();
	echo end_form();
}else{
	if(isset($_GET['id'])){
		$elem_id=$mysqli->real_escape_string($_GET['id']);
		$elem_row=get_row("elementit", $elem_id);
		if($elem_row['nakyva']!=1){
			echo "Permission denied.";
			exit();
		}
		$elem_kuvaus=$elem_row['kuvaus'];
		$elem_sisalto=$elem_row['sisalto'];
	}
	else{
		echo "Permission denied.";
		exit();
	}
	echo start_form("index.php", "post",true);
	echo start_table();
	echo "<tr><b>".$elem_kuvaus."</b></tr>";
	print_textrow("ID", "id", $elem_id, false);
	print_textarearow("Sisältö", "sisalto", htmlentities($elem_sisalto));
	print_submitrow("post_elementti", "OK");
	echo end_table();
	echo end_form();
}
?>
<script src="lib/ace/ace.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
var editor;
document.addEventListener('DOMContentLoaded', function(){
	console.log("DOM loaded");
    editor = ace.edit("ace");
    editor.setTheme("ace/theme/crimson_editor");
	editor.setOptions({
		minLines:10,
		maxLines:30
	});
    //editor.getSession().setMode("ace/mode/javascript");
	document.getElementById("submit").addEventListener("click", function(event){
	if(!save_ready){
		document.getElementById("merkki").style.backgroundColor="magenta";
		event.preventDefault();
		click=true;
		
	}
	});
	save_sisalto();
	saving=false;
});
var saving=false;
var save_ready=false;
var click=false;
function form_update(again){
	save_ready=false;
	document.getElementById("merkki").style.backgroundColor="lightgreen";
	if(!saving){
		save_sisalto();
		setTimeout(function(){	
			save_sisalto();
			saving=false;
			if(click){
				document.getElementById("submit").click();
			}
		}, 1500);
	}
}
function save_sisalto(){
	saving=true;
	var sisalto="";
	var lines=document.getElementsByClassName("ace_line");
	if(lines.length>0){
	for(var i=0;i<lines.length;i++){
		sisalto+=unescape(lines[i].innerHTML);
		if(i<lines.length-1)
			sisalto+="\r\n";
	}
	}
	var code=editor.getValue();
	document.getElementById("textarea1").value=code;
	document.getElementById("merkki").style.backgroundColor="green";
	save_ready=true;
}
function form_submit(event){
	if(!save_ready){
		event.preventDefault();
	}
}
</script>
