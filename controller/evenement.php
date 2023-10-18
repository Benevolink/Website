<?php
$file_name = basename(__FILE__);
if(isset($_GET["iframe"]) ? 1 : 0){
    $iframe = true;
}
require_once __DIR__.'/../links.php';

?>