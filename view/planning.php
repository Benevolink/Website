
<script src="<?= BF::abs_path("functions/classes/calendar/jquery.js")?>"></script>



<div id = "wrapper_all" style="display: flex;flex-wrap: wrap; margin-top: 30px;">
  <form id="liste_cate">
    <img src="<?= BF::abs_path("media/img/select.jpg") ?>" onclick="retrecir(this);" style="width: 20px; border-radius: 5px;cursor: pointer;"/>
    <div style="display: inline; font-size: 16px; font-weight: bold; padding-left: 20px; text-overflow: ellipsis; overflow: hidden;white-space: nowrap;">Catégories de missions</div>
    <br>
      <?php
      foreach($categories as $key => $value){
        creer_select_categorie($key,$value);
      }
      ?>
  </form>
    
  </div>

<style>
  #bouton_aide_decision_1{
    background-color: #FCD299;
    font-family: Corps;
  src: url(fonts/Nexa-Heavy.woff2) format("woff2");
    margin-left: 20px ;
    margin-bottom: 20px ;
  }

  #bouton_aide_decision_2{
    background-color: #FCD299;
    font-family: Corps;
  src: url(fonts/Nexa-Heavy.woff2) format("woff2");
    margin-right: 400px ;
    margin-bottom: 20px ;
    float: right;
  }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

<button type="button" id="bouton_aide_decision_1" class="btn btn-default"> Faire correspondre <br> automatiquement les bénévoles <br> aux missions sélectionnées</button>

<button type="button" id="bouton_aide_decision_2" class="btn btn-default"> Voir la proposition de planning <br>  avec notre aide à la décision</button>