<?php
require_once "../../links.php";
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>';


const MAX_ASSO = 20;
$max = MAX_ASSO;

if (isset($_POST["saisie"])) {
    $saisie = $_POST["saisie"];
    $query = "SELECT nom FROM asso WHERE nom LIKE ?";

    $query_temp = $db->prepare($query);
    $query_temp->execute([$saisie.'%']);
    $table = $query_temp->fetchAll();
  }
  ?>
  <data>
    <response>
      <?php 
      $i = 0;
      for($i = 0; $i<$max;$i++){
          if (isset($table[0][$i])) {
            echo $table[0][$i];
        }
      }
      ?>
    </response>
  </data>
