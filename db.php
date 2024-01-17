<?php
try{
    $db = new PDO('sqlite:'.__DIR__.'/database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
    echo "Impossible d'établir une connexion avec la base de données !";
    echo $e->getMessage();
    exit("Arrêt du script");
}
?>