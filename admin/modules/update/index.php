<?php
echo "Päivitys...<br>";
echo "<ul>";
echo "<li>";
echo str_replace("\r\n","</li><li>",shell_exec("sh modules/update/update.sh 2>&1"));
echo "</li>";
echo "</ul>";
?>
