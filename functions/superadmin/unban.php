<?php
require_once __DIR__.'/../../links.php';
require_once __DIR__.'/../../libs/Admin_site.php';


function unban($person){
  if (Admin_site::existence_user($person)){
    $res = Admin_site::set_unban($person);
    return $res;
  }
  return 0;
}

/*
@$_POST['person'] la personne à bannir
*/
$resp = array();
$status = unban(intval($_POST['person']));
$resp['statut'] = $status;
echo  json_encode($resp,JSON_UNESCAPED_UNICODE);
exit();
?>