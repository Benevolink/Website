<?php
require_once "../../links.php";
/*
$_POST['email']
$_POST['mdp']
$_POST['mdp2']
$_POST['tel']

1) Vérifier que tous ces éléments (sauf le tel) sont postés ( on peut utiliser BF::is_posted)

2) Vérifier que l'email est unique tout comme le téléphone (si le téléphone est spécifié) + bon format

3) Vérifier que mdp = mdp2

Si c'est le cas alors on renvoie un tableau de la forme :
(utiliser json_encode)

{
'statut': 1
}

Si il y a une erreur, on renvoie :
{
'statut': 0,
'message_erreur': '....'
}

*/





$tableau = array();
if(!isset($_POST['email'])){
  $tableau['statut']=0;
  $tableau['message_erreur']= 'Veuillez renseigner une adresse mail';
  echo  json_encode($tableau,JSON_UNESCAPED_UNICODE);
  exit();}
if(!isset($_POST['mdp'])){
  $tableau['statut']=0;
  $tableau['message_erreur']= 'Veuillez renseigner un mot de passe';
  echo  json_encode($tableau,JSON_UNESCAPED_UNICODE);
  exit();}
if(strlen($_POST['mdp'])<9){
  $tableau['statut']=0;
  $tableau['message_erreur']= 'Le mot de passe doit contenir plus de 8 caratère';
  echo  json_encode($tableau,JSON_UNESCAPED_UNICODE);
  exit();}
// vérifier que le mdp est assez bien sécurisé
//première étape : vérifier si la chaine a un caractère spécial

//parcourir la chaine caractère après caractère pour vérifier qu'il y a bien un de chaque type
$maju = false;
$minu = false;
$cara_spec= false;
$chiffre= false;
$lettre= false;
for($i=0;$i<strlen($_POST['mdp']);$i++){
  $test=$_POST['mdp'][$i];
  if(ctype_alpha($test)){$lettre = true;}
  if(ctype_digit($test)){$chiffre= true;}
  if(!ctype_alnum($test)){$cara_spec= true;}
  if(ctype_alpha($test)){
      if(ctype_lower($test)){$minu= true;}
      if(ctype_upper($test)){$maju= true;}
  }
}
if(!($maju && $minu && $cara_spec && $chiffre && $lettre)){
  $tableau['statut']=0;
  $tableau['maj']=$maju;
  $tableau['min']=$minu;
  $tableau['cara_spe']=$cara_spec;
  $tableau['chiffre']=$chiffre;
  $tableau['lettre']=$lettre;
  $tableau['message_erreur']= 'Le mot de passe doit contenir une majuscule, une minuscule, un chiffre et un caractère spécial';
  echo  json_encode($tableau,JSON_UNESCAPED_UNICODE);
  exit();
  }





/*deuxième étape vérifier si après avoir enlever le caractère spécial il y a tt les trucs nécessaires
if(ctype_alnum($_POST['mdp']) or ctype_alpha($_POST['mdp']) or ctype_digit($_POST['mdp']) or ctype_lower($_POST['mdp']) or ctype_upper($_POST['mdp'])){
  $tableau['statut']=0;
  $tableau['message_erreur']= 'Le mot de passe doit contenir une majuscule, 
  une minuscule, un chiffre et un caractère spécial';
  echo  json_encode($tableau,JSON_UNESCAPED_UNICODE);
  exit();
}*/

//comparer les deux mots de passe rentrés
  
if(!isset($_POST['mdp2'])){
  $tableau['statut']=0;
  $tableau['message_erreur']= 'Veuillez confirmer le mot de passe';
  echo  json_encode($tableau,JSON_UNESCAPED_UNICODE);
  exit();}
if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
  //l'email n'est pas valide
  $tableau['statut']=0;
  $tableau['message_erreur']= 'Format email invalide';
  echo  json_encode($tableau,JSON_UNESCAPED_UNICODE);
  exit();
}
if(strcmp($_POST['mdp'],$_POST['mdp2'])!=0){
  //les deux mots de passe ne sont pas identiques
  $tableau['statut']=0;
  $tableau['message_erreur']= 'Les mots de passe sont différents';
  echo  json_encode($tableau,JSON_UNESCAPED_UNICODE);
  exit();
}
if(isset($_POST['tel']) and (strlen($_POST['tel'])!=10 or strcmp(substr($_POST['tel'],0,1),'0')))/* = format telephone non valide*/{
  //le téléphone a été renseigné mais pas au bon format
  $tableau['statut']=0;
  $tableau['message_erreur']= "Le numéro de téléphone n'est pas au bon 
  format";
  echo  json_encode($tableau,JSON_UNESCAPED_UNICODE);
  exit();
}
//on a bien vérifié que tout les champs ont été remplis correctement donc on peut commencer à coder la fonction
//on va vérifier que l'adresse mail n'est pas déjà utilisé

$req_mail = "SELECT * FROM users WHERE email = ?";
$req_mail2 = $db->prepare($req_mail);
$req_mail2->execute([$_POST['email']]);
$table_mail = $req_mail2->fetch(PDO::FETCH_ASSOC);

if(!empty($table_mail)){
  $tableau['statut']=0;
  $tableau['message_erreur']= "L'adresse mail est déjà utilisée";
  echo  json_encode($tableau,JSON_UNESCAPED_UNICODE);
  exit();
}

if(isset($_POST['tel'])){
  $req_tel = "SELECT * FROM users WHERE tel = ?";
  $req_tel2 = $db->prepare($req_tel);
  $req_tel2->execute([$_POST['tel']]);
  $table_tel = $req_tel2->fetch(PDO::FETCH_ASSOC);
  if(!empty($table_tel)){
    $tableau['statut']=0;
    $tableau['message_erreur']= "Le numéro de téléphone est déjà utilisé";
    echo  json_encode($tableau,JSON_UNESCAPED_UNICODE);
    exit();
    
  }
}

$tableau['statut']=1;
echo  json_encode($tableau,JSON_UNESCAPED_UNICODE);
exit();

 
 

  /*
  [
  [
  'nom'=>'charlie','mdp'=>'mdp_de_charlie'
  ],
  [
  ''
  ]
  ]
*/
   



?>