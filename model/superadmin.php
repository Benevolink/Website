<?php
require_once __DIR__ . '/../libs/Admin_site.php';
?>

<header>
  <script>
    <?php
      $nb_domains = Admin_site::get_nb_domain();
    ?>
    nb_domains = <?php echo $nb_domains[0]; ?>;
    function manage_interest(man_mode, man_domain,id_div){
      $.ajax({
        url: abs_path('functions/superadmin/domain.php'),
        method: 'POST',
        dataType: 'json',
        data: {
          mode: man_mode,
          value: man_domain,
      }
    }).done(function(rep){
        status = rep['statut'];
        console.log(status);
        nb_domains +=1;
        
        if((man_mode == 'new') && status == 1){
          
          lst_int = document.getElementById('tab_domaines');
          new_int = document.createElement("div");
          new_txt = document.createElement("p");
          new_button = document.createElement("button");

          
          new_int.setAttribute("id", "domaine"+nb_domains);

          new_txt.innerText = man_domain;
          
          new_button.innerText = 'delete';
          new_button.setAttribute("onclick","manage_interest('del', this.parentElement.childNodes[0].innerText, 'domaine"+nb_domains+"')");

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
  <script>
    <?php
        $nb_ban = Admin_site::get_nb_ban();
      ?>
    nb_ban = <?php echo $nb_ban[0]; ?>;
    
    function ban(person, id_div, first_name, last_name){
      $.ajax({
        url: abs_path('functions/superadmin/ban.php'),
        method: 'POST',
        dataType: 'json',
        data: {
          person: person,
      }
      }).done(function(rep){
        status = rep['statut'];
        nb_ban +=1;
        console.log(rep);
        if (status == 1){
          div_del = document.getElementById(id_div);
          div_del.remove();

          lst_bans = document.getElementById('tab_bans');
          new_ban = document.createElement("div");
          new_txt = document.createElement("p");
          new_txt2 = document.createElement("p");
          new_button = document.createElement("button");

          new_ban.setAttribute("id", "banned"+nb_ban);

          new_txt2.innerText = "First Name : "+first_name;
          new_txt.innerText = "Last Name : "+last_name;
          
          new_button.innerText = 'unban';
          new_button.setAttribute("onclick","unban("+person.toString()+",'banned"+nb_ban+"')");

          new_ban.appendChild(new_txt);
          new_ban.appendChild(new_txt2);
          new_ban.appendChild(new_button);
          lst_bans.appendChild(new_ban);

          
        }
      }).fail(function(error){
        console.log(error);
      })
    }
  </script>
  <script>
    function unban(person, id_div){
      $.ajax({
        url: abs_path('functions/superadmin/unban.php'),
        method: 'POST',
        dataType: 'json',
        data: {
          person: person,
      }
      }).done(function(rep){
        status = rep['statut'];
        console.log(rep);
        if (status == 1){
          div_del = document.getElementById(id_div);
          div_del.remove();

        }
      }).fail(function(error){
        console.log(error);
      })
    }
  </script>
  <script>
    function show(id_comments){
      document.getElementById(id_comments).hidden = 1-document.getElementById(id_comments).hidden;
    }
  </script>
</header>

<?php /*FONCTION POUR AFFICHER LES DOMAINES*/
function create_tab_domains(){
  $domains = Admin_site::get_domain_list();

  ?>
  <div id=tab_domaines>
    <div>
      <input placeholder="intérêt à ajouter"/>
      <button onclick="manage_interest('new', this.parentElement.childNodes[1].value, '')">add</button>
    </div>
  
    <?php
      for ($i = 0; $i < count($domains); $i++) {
        ?>
        <div id="domaine<?php echo $i; ?>">
          <p><?php echo $domains[$i][0] ?></p>
          <button onclick="manage_interest('del', this.parentElement.childNodes[1].innerText, 'domaine<?php echo $i; ?>')">delete</button>
        </div>
    <?php
      }
  ?>
  </div>
  <?php
  

}

function create_tab_reports(){
    /*
  on récupère les noms + prénoms des personnes signalées 
  on récupère aussi rapidos pour chaque personne signalée le nb de fois où il l'a été
  Comme tout est ordonné par id, on a :
  
  $reports[*][n] = $nb_reports[*][n] pour tout n
  
  la requete en plus lisible :
  
  "SELECT s.id_cible, COUNT(s.id_source) FROM signalements s GROUP BY s.id_cible ORDER BY id_cible JOIN (SELECT u.nom FROM users u) ON u.id=s.id_cible"
  */
    $nb_reports = Admin_site::get_reports_list();
  ?>
  
  <div id=tab_reports>

  <?php
  
    for ($i=0; $i<count($nb_reports); $i++){
      
      $identity = Admin_site::get_report_identity($nb_reports[$i][0]);
      ?>
      

        <div id="report<?php echo $i; ?>">
          <p>Last Name : <?php echo $identity[0][0]; ?></p>
          <p>First Name : <?php echo $identity[0][1]; ?></p>
          <p>Number of reports : <?php echo $nb_reports[$i][1]; ?></p>
          <button onclick="show('comments<?php echo $i; ?>')">show reports</button>
          <div id="comments<?php echo $i; ?>" hidden>
            <?php
              $comments = Admin_site::get_reported_messages($nb_reports[$i][0]);

              for ($j=0; $j<count($comments); $j++){
            ?>
                <p><?php echo $comments[$j][0]." : ".$comments[$j][1] ?></p>
            <?php
              }
            ?>
          </div>
          <button onclick="ban(<?php echo $identity[0][2]; ?>, 'report<?php echo $i; ?>', '<?php echo $identity[0][1]; ?>', '<?php echo $identity[0][0]; ?>')">ban</button>
        </div>
        
      <?php
    }
  ?>

  </div>
  <?php
}

function create_tab_banned(){
  $bans = Admin_site::get_ban_list();
  ?>
  <div id=tab_bans>
  <?php
  
  for ($i=0; $i<count($bans); $i++){
      
      ?>
        <div id="banned<?php echo $i ?>">
          <p>Last Name : <?php echo $bans[$i][1]; ?></p>
          <p>First Name : <?php echo $bans[$i][2]; ?></p>
          <button onclick="unban(<?php echo $bans[$i][0]; ?>, 'banned<?php echo $i ?>')">unban</button>
        </div>
        
      <?php
      
    }
  ?>
  </div>
  <?php
}
?>
