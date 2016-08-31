<?php
if($_SESSION['authenticated']!=true){
	echo "Permission denied.";
	exit();
}
?>
