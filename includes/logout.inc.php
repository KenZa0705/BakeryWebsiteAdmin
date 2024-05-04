<?php
session_start();
//clear session
$_SESSION = [];
session_destroy();
header("Location: ../index.php");
exit();

