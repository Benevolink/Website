
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
    require_once "../../abs_path.php";
    ?>

<?php
?>
<script type="text/babel" src = "./LeaveCross.jsx"></script>
<script type="text/babel" src = "./FrontElement.jsx"></script>
<script type="text/babel" src = "./PopUp.jsx"></script>
