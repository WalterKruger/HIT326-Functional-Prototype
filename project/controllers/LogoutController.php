<?php
session_start();
session_unset();
session_destroy();
header('Location: /lao/project/views/login.php');
exit;
?>
