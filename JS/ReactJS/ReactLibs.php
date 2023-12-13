
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>React Local</title>
  <script type="application/javascript" src="https://unpkg.com/react@18.0.0/umd/react.production.min.js"></script>
  <script type="application/javascript" src="https://unpkg.com/react-dom@18.0.0/umd/react-dom.production.min.js"></script>
  <script type="application/javascript" src="https://unpkg.com/babel-standalone@6.26.0/babel.js"></script>
    <script>
         Babel.registerPreset("@babel/preset-react", {
        "presets": ["@babel/preset-env", "@babel/preset-react"],
        "plugins": ["@babel/plugin-proposal-class-properties"]
        });
    </script>
    <?php
    require_once "../abs_path.php";
    ?>

<?php

$repertoire = "templates"; // Remplacez cela par le chemin de votre répertoire

// Obtenez la liste des fichiers dans le répertoire
$files = scandir($repertoire);

// Parcours de chaque fichier dans le répertoire
foreach ($files as $file) {
    // Ignorer les fichiers "." et ".." qui représentent le répertoire courant et le répertoire parent
    if ($file != "." && $file != "..") {
        
        ?>
        <script type="text/babel" src = "<?= $repertoire."/".$file ?>"></script>
        <?php
        
    }
}

?>

