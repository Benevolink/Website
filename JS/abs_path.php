<?php require_once __DIR__."/../links.php"; ?>
<script>
  function abs_path(lien){
    return "/<?= BF::equals($path_html,"")? "" : substr($path_html,1)."/" ?>"+lien;
  }
</script>