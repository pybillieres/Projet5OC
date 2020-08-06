<?php
require 'vendor/autoload.php';
use Model\Movie;
use Model\MovieManager;

$manager = new MovieManager;
var_dump($manager->lastMovie());


/*
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Titre de la page</title>
  <base href="/projet5/">
  <script src=public/js/ajax.js></script>
  <script src=public/js/home.js></script>
  <script src=public/js/main.js></script>
</head>
<body>

</body>
</html>
*/