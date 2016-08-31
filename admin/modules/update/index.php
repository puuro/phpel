<?php
function eki_shell($cmd){
	echo "<li>";
	echo "<b>".$cmd."</b><br>";
	$val=shell_exec($cmd." 2>&1");
	echo "</li>";
	return $val;
}
echo "Päivitäättör v2<br>";
echo "Päivitys...<br>";
echo "<ul>";
chdir("modules/update");
$pwd=eki_shell("pwd");
$parts=explode("/", $pwd);
$ln=count($parts);
if(trim($parts[$ln-1])!="update" || $parts[$ln-2]!="modules" || $parts[$ln-3]!="admin"){
	echo "<br>Väärä kansio: ".$pwd."<br>";
	echo "Pitäisi olla ....../admin/modules/update";
	exit();
}

eki_shell("wget https://github.com/puuro/phpel/archive/master.zip");
if(!is_file("master.zip")){
	echo "Lataus epäonnistui. ei master.zip tiedostoa kansiossa ".eki_shell("pwd").".";
	exit();
	
}
eki_shell("unzip master.zip");
echo eki_shell("rm master.zip");
echo eki_shell("mv phpel-master/* .");
echo eki_shell("rm -r phpel-master");
if(!is_dir("admin")){
	echo "Ei admin-kansiota kansiossa ".eki_shell("pwd").".";
	exit();
}
echo eki_shell("rm admin/files.list");
echo eki_shell("rm admin/files.test");
echo eki_shell("rm admin/include.list");
echo eki_shell("cp -r admin/modules/update ../update2/");
echo eki_shell("rm -r admin/modules/update*");
echo eki_shell("cp -r admin/* ../..");
echo eki_shell("rm -r admin");
echo eki_shell("sh ../update2/update2.sh");
//echo str_replace("\r\n","</li><li>",shell_exec("sh modules/update/update.sh 2>&1"));
echo "</ul>";
?>
