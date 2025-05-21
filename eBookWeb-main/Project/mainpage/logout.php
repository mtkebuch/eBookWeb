<?php
session_start();
session_destroy();
header("Location: ../welcomepage/welcome.php");
exit;
?>
