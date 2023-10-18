<?php
require_once __DIR__.'/../../links.php';
require_once __DIR__.'/../../libs/Admin_site.php';

function create_domain($value){
  
  if (!Admin_site::existence_domain($value)){
    $res = Admin_site::insert_domain($value);
    return $res;
  }
  return 0;  
}

function del_domain($value){
  if (Admin_site::existence_domain($value)){
    $res = Admin_site::del_domain($value);
    return $res;
  }
  return 0;
}



/*
@$_POST['mode'] 'del' / 'new' to delete / create
@$_POST['value'] = nom_domaine
*/
$resp = array();
if (strcmp($_POST['mode'], 'del') == 0){
  $status = del_domain($_POST['value']);
}
if (strcmp($_POST['mode'], 'new') == 0){
  $status = create_domain($_POST['value']);
}


$resp['statut'] = $status;
echo  json_encode($resp,JSON_UNESCAPED_UNICODE);
exit();


?>