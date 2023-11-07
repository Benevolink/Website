<?php

class Admin_site{
  /*GET BANS*/
  
  public static function get_nb_ban(){
    /*
    gets the number of banned people
    */
    $nb_ban = BF::request("SELECT COUNT(*) FROM users WHERE account_status = 9", [], true, true, false);
    return $nb_ban;
  }

  public static function get_ban_list(){
    /*
    gets the liost of banned people
    */
    $bans = BF::request("SELECT id, nom, prenom FROM users WHERE account_status = 9", [], true);
    return $bans;
  }

  /*GET DOMAINS*/
  
  public static function get_nb_domain(){
    /*
    gets the number of domains
    */
    $nb_int = BF::request("SELECT COUNT(*) FROM domaine", [], true, true, false);
    return $nb_int;
  }
  
  public static function get_domain_list(){
    /*
    gets the list of domains
    */
    $domains = BF::request("SELECT nom_domaine FROM domaine", [], true, false, false);
    return $domains;
  }

  /*GET REPORTS*/
  
  public static function get_reports_list(){
    /*
    gets the list of reports
    */
    $nb_reports = BF::request("SELECT s.id_cible, COUNT(s.id_source) FROM signalements s GROUP BY s.id_cible ORDER BY id_cible", [], true);
    return $nb_reports;
  }

  public static function get_report_identity($id){
    /*
    gets the full name of the reported person
    */
    $identity = BF::request("SELECT nom, prenom, id FROM users WHERE id=?", [$id], true);
    return $identity;
  }

  public static function get_reported_messages($id){
    /*
    gets the messages from associations that reported the pêrson
    */
    $comments = BF::request("SELECT a.nom, s.message FROM signalements s LEFT JOIN assos a ON s.id_source = a.id WHERE id_cible=?", [$id], true);
    return $comments;
  }

  /*EXISTENCE*/

  public static function existence_user($id){
    /*
    check if the user exists
    returns 0 if doesn't exist, 1 if does
    */
    $exists = BF::request("SELECT COUNT(*) FROM users WHERE id = ?", [$id], true, true);
    return $exists[0]>0;
  }

  public static function existence_signal($id){
    /*
    check if the users has been reported
    */
    $exists = BF::request("SELECT COUNT(*) FROM signalements WHERE id_cible = ?", [$id], true, true);
    return $exists[0]>0;
  }

  public static function existence_in_association($id){
    /*
    checks id the user is in an association
    */
    $exists = BF::request("SELECT COUNT(*) FROM membres_assos WHERE id_user = ?", [$id], true, true);
    return $exists[0]>0;
  }

  public static function existence_domain($domain){
    /*
    checks if domain already exists
    */
    $exists = BF::request("SELECT COUNT(*) FROM domaine WHERE nom_domaine = ?", [$domain], true, true);
    return $exists[0]>0;
  }

  /*SET BAN*/
  
  public static function set_ban($id){
    /*
    bans the user
    */
    $user_del = BF::request("UPDATE users SET account_status = 9 WHERE id = ?", [$id]);
    $user_del2 = BF::request("DELETE FROM signalements WHERE id_cible = ?", [$id]);
    if(Admin_site::existence_in_association($id)){
      $user_del3 = BF::request("DELETE FROM membres_assos WHERE id_user = ?", [$id]);
    }
    return 1;
  }

  public static function set_unban($id){
    /*
    unbans a banned person
    */
    $user_del = BF::request("UPDATE users SET account_status = 0 WHERE id = ?", [$id]);
    return $user_del;
  }

  /*SET DOMAIN*/

  
  public static function insert_domain($domain){
    /*
    inserts a new domain in db
    */
    $insert = BF::request("INSERT INTO domaine (nom_domaine) VALUES (?)" , [$domain]);
    return 1;
  }

  public static function del_domain($domain){
    /*
    deletes domain from everywhere
    */
    $users_res = BF::request("DELETE FROM domaine_jonction WHERE id_domaine = (SELECT id_domaine FROM domaine WHERE nom_domaine = ?)", [$domain]);
    $res = BF::request("DELETE FROM domaine WHERE nom_domaine = ?", [$domain]);
    return 1;
  }
  
}

?>