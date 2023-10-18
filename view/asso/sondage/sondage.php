<?php 
    //On récupère les infos sur l'association
    $req = "SELECT a.* FROM assos a JOIN sondage s ON a.id = s.id_asso WHERE s.id = ?";
    $rep = BF::request($req,[$_GET["id_sondage"]],true,true,PDO::FETCH_ASSOC);
    
?>
<style>
    .main_titre{
        font-size: 150%;
        font-weight: bold;
        margin-left: 30px;
    }
</style>
<a class="main_titre" href= "<?= BF::abs_path("controller/asso/association.php?id=".$rep["id"]) ?>">
    Association : <?= BF::XSS($rep["nom"]) ?>
</a>
<div id="myChart" style="max-width:700px; height:400px"></div>
<div id="select_response">
</div>