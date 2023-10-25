<?php
if(file_exists(__DIR__.'/../../eds-www')){
    $path_html = '/Website';
}else{
    $path_html = '';
    
}

$path = __DIR__.'/';
//On importe la BDD
require_once __DIR__."/db.php";
//Importation de la bibliothèque BF
require_once __DIR__.'/functions/basic_functions.php';
require_once BF::abs_path("/JS/abs_path.php",true);
BF::sess_start();
if(!isset($a_jour)){
  $a_jour = false;
}

if(isset($file_name) && !$a_jour){
    ob_start();
    if(file_exists(__DIR__."/JS/before/$file_name")){
        include_once __DIR__."/JS/before/$file_name";
    }
    if(file_exists(__DIR__."/view/$file_name")){
        include_once __DIR__."/view/$file_name";
    }
    if(file_exists(__DIR__."/JS/after/$file_name")){
        include_once __DIR__."/JS/after/$file_name";
    }
    $content = ob_get_clean();
    
    include_once __DIR__.'/view/template.php';
    
}
?>