<?php
//Farhans aziz hermansya-2440044251
session_start();
session_unset();
session_destroy();
header("Location: index.php");
exit();
?>
