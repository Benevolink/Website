<?php
require_once BF::abs_path("libs/Domaine.php");

function show_all_domaines(){
    $domaines = Domaine::get_all();
    if(!empty($domaines)) {
        foreach ($domaines as $domaine) {
            $id_domaine = $domaine['id_domaine'];
            $nom_domaine = $domaine['nom_domaine'];
            ?><label>
                <input type="checkbox" name="domaine[]" value="<?=$id_domaine?>"> <?=$nom_domaine?> </label><br>
            <?
        }
    } else {
        echo "Aucun domaine n'a été trouvé dans la base de données.";
    }
}
?>