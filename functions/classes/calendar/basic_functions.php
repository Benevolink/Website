<?php
/**
 * Un répertoire de fonctions basiques pour nous faciliter la vie
 * 
 * @author Emeric Braud
 */

/**
 * Cette fonction compare deux strings et retourne true si elles sont égales
 * 
 * @param string $string1
 * 
 * @param string $string2
 * 
 * @return boolean
 */
function same($string1, $string2){
    return strcmp($string1,$string2)==0;
}

/**
 * Renvoie le $_GET ou le $_COOKIE ou le $_POST ou "" si ça n'existe pas
 * 
 * @param string $string
 * 
 * @throws string ""
 * 
 * @return ... la valeur $_GET[$string] / $_COOKIE[$string] / $_POST[$string] 
 */
function valid_intern($string){
    if(isset($_GET[$string])){
        return $_GET[$string];
    }
    if(isset($_COOKIE[$string])){
        return $_COOKIE[$string];
    }
    if(isset($_POST[$string])){
        return $_POST[$string];
    }
    return "";
}
/**
 * Même fonction que valid_intern mais qui fonctionne aussi pour des listes
 */
function valid($string){
    if(is_array($string)){
        foreach($string as $key => $value){
            if(!valid_intern($value)){
                return false;
            }
        }
        return true;
    }return valid_intern($string);
}
?>