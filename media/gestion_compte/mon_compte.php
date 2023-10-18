

<link rel="stylesheet" href="<?= BF::abs_path("CSS/mon_compte.css")?>">


<?php if(BF::is_connected()){
$id = $_SESSION["user_id"];
$table = BF::request("SELECT * FROM users WHERE id = ?",[$id],true,false,PDO::FETCH_ASSOC);
?>

<div class="liste_prop" style="display: inline-block; margin-left: 100px;">
<div>
    <img id ="image_logo" src="<?= BF::abs_path("/media/img/user_anonyme.jpg")?>" style="width:200px;border-radius:200px;border: 10px black solid;cursor: pointer;"/>
    <br>
    Nom: <?= $table[0]["pseudo"] ?>
<br>
    Tel : <?=$table[0]["tel"]?>
<br>
    email : <?= $table[0]["email"]?>
    

</div>
<div style="cursor: pointer;" onclick="confirmer('<?= BF::abs_path('controller/gestion_compte/functions/modif_mdp.php')?>','modifier le mot de passe');">
    Modifier le mot de passe
</div>
<div style="cursor: pointer;" onclick="confirmer('<?= BF::abs_path('controller/gestion_compte/functions/deconnexion.php')?>','se déconnecter');">
    Déconnexion
</div>
<div style="cursor: pointer;" onclick="confirmer('<?= BF::abs_path('controller/gestion_compte/functions/suppr_compte.php')?>','supprimer le compte');">
    Supprimer le compte
</div>

</div>
<div class="liste_prop" style="display: inline-block">
    <div style="cursor: pointer;" onclick="confirmer('<?= BF::abs_path('controller/asso/associations_user.php')?>','accéder aux associations');">
    Liste des associations
</div>
  </div>
<?php
}else{
?>
<script>
message_alerte("Veuillez vous authentifier");
</script>
<?php
} 
?>

