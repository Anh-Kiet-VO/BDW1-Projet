<!--     PAGE D'ACCUEIL     -->

<?php
session_start();
require_once 'php/bd.php';
require_once 'php/utilisateur.php';
require_once 'php/photo.php';

$link = getConnection($dbHost, $dbUser, $dbPwd, $dbName);

$pathsList = getImagesPaths($link);

function displayPhotos($array)
{
    foreach ($array as $value) {
        $html = '<img src="' . $value . '">';
        echo $html;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Application mini-Pinterest</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <div class="navigation"><span class="logo">mini-pinterest.</span><a class="boutonNav" href="./index.php">accueil</a> <a class="boutonNav" href="./connexion.php">se connecter</a> <a class="boutonInscrip" href="./inscription.php">s'inscrire</a></div>

  <div class="blocprincipal">
    <div class="categories">
      <form action="index.php" method="POST">
        <input type="radio" id="categorie1" name="categorie" value="categorie1"><label for="categorie1">Catégorie 1</label>
        <input type="radio" id="categorie2" name="categorie" value="categorie2"><label for="categorie2">Catégorie 2</label>
        <input type="radio" id="categorie3" name="categorie" value="categorie3"><label for="categorie3">Catégorie 3</label>
      </form>
    </div>
    <div class="galerie"><?php displayPhotos($pathsList); ?></div>
  </div>

</body>

</html>
