<!--     DETAIL D'UNE PHOTO     -->

<?php
session_start();
require_once 'php/bd.php';
require_once 'php/utilisateur.php';
require_once 'php/photo.php';

print_r($_SESSION);

$link = getConnection($dbHost, $dbUser, $dbPwd, $dbName);

$imageNom = $_GET["img_nomFich"];

$tabDetail = detail($imageNom, $link);

$tabNomCat = getNomCat($imageNom, $tabDetail['catId'], $link);

function displayPhoto($nomFich)
{
    $html = '<img class="" src="' . $nomFich . '">';
    echo $html;
}

echo "<br />";

if (empty($_SESSION)) {
  $connectState = 0;
} else {
  $connectState = 1;
  $utilisateur = $_SESSION["user"];
  if (!empty($_SESSION["user"])) {
      $time = time() - $_SESSION["time"];
      $readableTime = timeElapsed($time);
      echo $readableTime;
      echo "<br />";
      echo "Bonjour " . $utilisateur;
  }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Application mini-Pinterest</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
</head>

<body>

  <div class="navigation"><span class="logo">mini-pinterest.</span><a class="boutonNav" href="./index.php">accueil</a> <a class="boutonNav" href="./connexion.php">se connecter</a> <a class="boutonInscrip" href="./inscription.php">s'inscrire</a></div>

  <div class="detailphoto">
    <table>
      <tr>
        <td>
        <?php
          displayPhoto($tabDetail['nomFich']);
        ?>
        </td>
      </tr>
      <tr>
        <th>Description</th>
        <td>
          <?php
            echo $tabDetail['description'];
          ?>
        </td>
      </tr>

      <tr>
        <th>Nom du fichier</th>
        <td>
            <?php
              echo $tabDetail['nomFich'];
            ?>
        </td>
      </tr>
      <tr>
        <th>Catégorie</th>
        <td>
          <a href="index.php?img_nomCat=<?php
            echo $tabDetail['catId'];
          ?>">
          <?php
            echo $tabNomCat['nomCat'];
          ?>
        </a>
        </td>
      </tr>
    </table>
  </div>

</body>

</html>
