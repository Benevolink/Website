<?php
require_once "links.php";

if(BF::is_connected()){
  $id = $_SESSION["user_id"];
  $stmt = $db->prepare("DELETE FROM users WHERE id = :id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
}
?>