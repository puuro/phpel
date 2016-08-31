<?php
session_start();
include "check_auth.php";
session_destroy();
?>
<html>
<body>
Olet kirjautunut ulos.<br>
<a href="index.php">Etusivu</a>
</body>
</html>
<?php
?>
