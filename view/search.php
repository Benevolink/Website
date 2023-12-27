<link rel="stylesheet" href="<?= BF::abs_path("CSS/search.css") ?>">
<table class="table table-striped table-bordered" id="list_assos">

  
<?php
foreach($table as $index => $row){
  ?>
  <tr onclick="<?='window.location.href='."'".'asso/association.php?id='.$row["id"]."';"?>" >
    <td>
      <img class="image_table" src="<?= BF::abs_path($row["logo"]) ?>" >
      <?php
        $asso = new Asso($row["id"]);
      ?> 
    </td>
    <td> <?= BF::XSS($row["nom"]) ?></td>
    <td><?= "Membres : ". $asso->get_nombre_membres() ?> </td>
  </tr>
  <?php
}

?>
</table>
