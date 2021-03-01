<?php
unset($_SESSION["per_login"]);
unset($_SESSION["per_num"]);
header("Location: index.php?page=0");
exit;
?>