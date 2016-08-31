<?php
include "check_auth.php";
echo "<a class='nappi' href='index.php?q=create&aa=tosi'>Luo sivut</a><br>";
echo "<a class='nappi' href='index.php?q=create&aa=testi'>Luo testisivut</a><br>";
echo "<a class='nappi' href='index.php?action=renode'>Päivitä meta</a><br>";
echo "<a class='nappi' href='index.php?q=update'>Päivitä työkalu uusimpaan versioon</a><br>";
if($_SESSION['taso']==2){
/*
echo "<p>";
echo print_table("sivut", array("id", "nimi", "vanhempi","root","julkinen"), "sivu");
echo "</p>";
*/

echo "<p>";
echo "<h3>Elementit</h3>";
echo print_table("elementit", array("nimi_upper", "kuvaus","sivu:sivut:kuvaus"), "elementti");
echo "</p>";
echo "<p>";
echo "<h3>Palikat</h3>";
echo "<span style='font-weight:bold;color:darkgreen;'>";
foreach($blocks as $block){
	echo $block."<br>";
}
echo "</span>";
echo "</p>";

echo "<h3>Käyttäjät</h3>";
echo "<p>";
echo print_table("kayttajat", array("nimi_upper", "taso"), "kayttaja");
echo "</p>";
echo "</div>";
}



?>
