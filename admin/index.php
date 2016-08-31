<?php
session_start();
if(!is_file("variables.php")){
	include "init.php";
	exit();
}
include "variables.php";
$mysqli =new mysqli($HOST, $USER, $PASS, $DATA);
	
if(mysqli_connect_errno()){
		echo "error";
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>
<?php
if($_SESSION['authenticated']!=true){
	if(isset($_POST['nimi']) && isset($_POST['sala'])){
		$nimi=$_POST['nimi'];
		$sala=$_POST['sala'];
		if($nimi!="" && $sala!=""){
			$nimi=$mysqli->real_escape_string($nimi);
			$sala=$mysqli->real_escape_string($sala);
			$result=$mysqli->query("SELECT id, taso, nimi FROM ".$PREFIX."kayttajat WHERE nimi='".$nimi."' AND sala='".md5($sala)."'");
			if($result->num_rows==1){
				$row=$result->fetch_assoc();
				$_SESSION['authenticated']=true;
				$_SESSION['taso']=$row['taso'];
				$_SESSION['nimi']=$row['nimi_upper'];
				$_SESSION['userid']=$row['id'];
			}
		}
	}
}
if(!isset($_SESSION['authenticated']) || $_SESSION['authenticated']!=true){
?>
<form action="index.php" method="post">
<table>
<tr>
<td>Käyttäjätunnus</td>
<td><input type="text" name="nimi"></td>
</tr>
<td>Salasana</td>
<td><input type="password" name="sala"></td>
<tr>
</tr>
<tr>
<td></td>
<td><input type="submit" value="OK"></td>
</tr>
</table>
</form>
</body>
</html>
<?php
exit();
}
include "include.php";
?>
<div class="otsikko">
<h3>Better Than Others Framework v0.01.4</h3>
<?php echo $_SESSION['nimi']; ?>
<a class="nappi" href="logout.php">Kirjaudu ulos</a>
<a class="nappi" href="index.php">Etusivu</a>
<a class="nappi" href="../">Käy sivulla</a>
<a class="nappi" href="testi/">Käy testisivulla</a>
<?php
foreach($links as $link){
echo "<a class='nappi' href='index.php?q=".$link."'>".$link."</a>";
}
?>
</div>
<?php
	include "editor.php";
?>
</body>
</html>
