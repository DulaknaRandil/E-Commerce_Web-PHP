<?php
session_start();
session_unset();
$isLoggedIn = false;
session_destroy();
header("Location: index.php");
exit();
?>
