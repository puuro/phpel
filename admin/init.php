 <html>
<head>
</head>
<body>
<?php
if(!isset($_POST['tietokanta_nimi'])){
?>
<form action="init.php" method="post">
<table>
<?php
$fields=array();
$fields[]=array("Tietokanta on jo", "checkbox", "tietokanta_on");
$fields[]=array("Tietokannan nimi", "text", "tietokanta_nimi");
$fields[]=array("Käyttäjä on jo", "checkbox", "kayttaja_on");
$fields[]=array("Käyttäjä", "text", "kayttaja_nimi");
$fields[]=array("Salasana", "text", "salasana");
$fields[]=array("Asennuskäyttäjä", "text", "root_kayttaja");
$fields[]=array("Salasana", "text", "root_salasana");
$fields[]=array("Taulujen etuliite", "text", "etuliite");
$fields[]=array("", "submit", "submit");
foreach($fields as $field){
	if($field[1]=="checkbox"){
		echo "<input type='hidden' name='".$field[2]."' value='0'>";
	}
	echo "<tr>";
	echo "<td>".$field[0]."</td>";
	echo "<td><input type='".$field[1]."' name='".$field[2]."' ";
   	if($field[1]=="checkbox"){
        echo "value='1'";
    }
    echo "></td>";
	echo "</tr>";
}
?>
</table>
</form>
</body>
</html>
<?php
exit();
}
else {
	if($_POST['tietokanta_on']==1) $db_on=true;
	else $db_on=false;
	if($_POST['kayttaja_on']==1) $user_on=true;
	else $user_on=false;
	$db_nimi=$_POST['tietokanta_nimi'];
	$user_nimi=$_POST['kayttaja_nimi'];
	$pass=$_POST['salasana'];
	$rootuser=$_POST['root_kayttaja'];
	$rootpass=$_POST['root_salasana'];
	$prefix=$_POST['etuliite'];
}
?>
<!--<a href="delete.php">Tyhjennä</a><br>-->
<?php
/*$HOST="localhost";
$USER="root";
$PASS="kakka";*/

$mysqli =new mysqli('localhost', $rootuser, $rootpass);
	
if(mysqli_connect_errno()){
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}
dbcmd("SET NAMES utf8");
if(!$db_on)
	dbcmd("CREATE DATABASE ".$db_nimi);
dbcmd("USE ".$db_nimi);
if(!$user_on){
	//dbcmd("CREATE USER IF NOT EXISTS ".$user_nimi." IDENTIFIED BY '".$pass."'");
	dbcmd("GRANT ALL PRIVILEGES ON ".$db_nimi.".* TO ".$user_nimi."@localhost IDENTIFIED BY '".$pass."'");
	dbcmd("FLUSH PRIVILEGES");
}
dbcmd("CREATE TABLE IF NOT EXISTS ".$prefix."sivut(
	id int primary key auto_increment,
	nimi varchar(128),
	vanhempi int,
	sivu int,
	root int,
	julkinen tinyint(1),
	nimi_upper varchar(128),
	kuvaus varchar(128),
	kaytossa tinyint(1),
    jarjestys int
)");
dbcmd("CREATE TABLE IF NOT EXISTS ".$prefix."kayttajat(
	id int primary key auto_increment,
	nimi varchar(128),
	sala varchar(128),
	taso int,
	aika int,
	nimi_upper varchar(128)
)");
dbcmd("CREATE TABLE IF NOT EXISTS ".$prefix."elementit(
	id int primary key auto_increment,
	nimi varchar(128),
	sisalto text,
	ryhma int,
	sivu int,
	aika int, 
	kuvaus varchar(256),
	nimi_upper varchar(128),
	nakyva tinyint(1)
)");
dbcmd("CREATE TABLE IF NOT EXISTS ".$prefix."meta(
	rivi_id int primary key auto_increment,
	id int,
	top int,
	sivu int,
	green tinyint(1)
)");
dbcmd("INSERT INTO ".$prefix."kayttajat
	(nimi, sala, taso, aika, nimi_upper) 
	VALUES('eki', '".md5('kakka')."', 2, ".time().", 'Eki'
)");
	

//file_put_contents("index.html", "Tyhjä");
//shell_exec("mkdir admin");
echo "write variables.php";
writeline("<?php");
writeline("\$HOST='localhost';");
writeline("\$USER='".$user_nimi."';");
writeline("\$PASS='".$pass."';");
writeline("\$DATA='".$db_nimi."';");
writeline("\$PREFIX='".$prefix."';");
writeline("?>");
function writeline($str){
	$str.="\r\n";
	echo $str;
	file_put_contents("variables.php", $str, FILE_APPEND);
}
chmod("variables.php", 0770);
echo "loppu init<br>";
?>
<a href="index.php">Siirry</a>
<?php

function dbcmd($str){
	global $mysqli;

	echo $str."<br>";
	if(!$mysqli->query($str)){
		printf("Error: %s\n", $mysqli->error);
		exit();
	}
}

?>
