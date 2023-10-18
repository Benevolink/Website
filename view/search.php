<?php
if(BF::is_posted("Recherche")){
  $r = $_GET["Recherche"];
}
else{
  $r = "";
}
$r = $r."%";
$table = BF::request("SELECT * FROM assos WHERE nom LIKE ? ORDER BY nom ASC",[$r],true);
?>
<link rel="stylesheet" href="<?= BF::abs_path("CSS/search.css") ?>">
<table id="list_assos">
  
<?php
if($table == NULL){
  exit("La table est nulle !");
}
foreach($table as $index => $row){
  ?>
  <tr onclick="<?='window.location.href='."'".'asso/association.php?id='.$row["id"]."';"?>" >
    <td>
      <img class="image_table" src="<?= BF::abs_path($row["logo"]) ?>" >
    </td>
    <td> <?= BF::XSS($row["nom"]) ?></td>
    
  </tr>
  <?php
}

?>
</table>
