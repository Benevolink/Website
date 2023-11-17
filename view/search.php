 <!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">


<link rel="stylesheet" href="<?= BF::abs_path("CSS/search.css") ?>">
<table class="table table-striped table-bordered" id="list_assos">

  
<?php
if($table == NULL){
  exit("La recherche est vide !");
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
