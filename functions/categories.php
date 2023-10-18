<?php
require_once __DIR__."/basic_functions.php";
$req = "SELECT * FROM domaine";
$categories = BF::request($req,[],true,false,PDO::FETCH_ASSOC);
?>
