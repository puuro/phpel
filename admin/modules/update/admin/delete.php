<?php
include "check_auth.php";
$HOST="localhost";
$USER="root";
$PASS="kakka";

$mysqli =new mysqli($HOST, $USER, $PASS);
	
if(mysqli_connect_errno()){
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}
$mysqli->query("DROP DATABASE eki_cms");


?>
<a href="index.php">Etusivulle</a>
