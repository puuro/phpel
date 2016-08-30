<?php
create_dir("../css");
create_file("../css/p.css", file_get_contents("modules/p/p.css"));
$included_content="<link rel='stylesheet' type='text/css' href='".get_dotdir($pageid)."css/p.css'>";
?>
