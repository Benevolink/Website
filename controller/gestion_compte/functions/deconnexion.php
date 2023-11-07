<?php
require_once "links.php";
$_SESSION["auth"] = 0;
$_SESSION["user_id"]=null;

header("Location: ../../../index.php");
session_destroy();
exit();
?>