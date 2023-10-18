<?php //<link rel="stylesheet" href="" />?>

<header>
  <script>
    function manage_interest(man_mode, man_interest,id_div){
      $.ajax({
        url: abs_path('functions/superadmin/interest.php'),
        method: 'POST',
        dataType: 'json',
        data: {
          mode: man_mode,
          value: man_interest,
      }
    }).done(function(rep){
        status = rep['statut'];
        console.log(rep);
        if((man_mode == 'new') && status == 1){
          lst_int = document.getElementById('tab_domaines');
          new_int = document.createElement("div");
          new_txt = document.createElement("p");
          new_button = document.createElement("button");

          <?php
            $nb_int = BF::request("SELECT COUNT(*) FROM domaine", [], true, true, false);
          ?>
          new_int.setAttribute("id", "domaine<?php echo $nb_int[0] ?>");

          new_txt.innerText = man_interest;
          
          new_button.innerText = 'delete';
          new_button.setAttribute("onclick","manage_interest('del', this.parentElement.childNodes[0].innerText, 'domaine<?php echo $nb_int[0] ?>')");

          new_int.appendChild(new_txt);
          new_int.appendChild(new_button);
          lst_int.appendChild(new_int);
        }
        if((man_mode == 'del') && status == 1){
          div_del = document.getElementById(id_div);
          div_del.remove();
        }
    }).fail(function(error){
        console.log(error);
    })
    
    }
  </script>

</header>

<?php
  $interests = BF::request("SELECT nom_domaine FROM domaine", [], true, false, false);
?>

<div id=tab_domaines>
  <div>
    <input placeholder="intérêt à ajouter"/>
    <button onclick="manage_interest('new', this.parentElement.childNodes[1].value, '')">add</button>
  </div>

  <?php
    for ($i = 0; $i < count($interests); $i++) {
      ?>
      <div id="domaine<?php echo $i ?>">
        <p><?php echo $interests[$i][0] ?></p>
        <button onclick="manage_interest('del', this.parentElement.childNodes[1].innerText, 'domaine<?php echo $i ?>')">delete</button>
      </div>
  <?php
    }
  ?>
  
</div>

