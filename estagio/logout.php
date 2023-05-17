<?php
session_start();
session_destroy();


header('location:login.php?msg=erro_dados');
exit;
?>