<!--     DETAIL D'UNE PHOTO     -->
<?php
require_once 'php/bd.php';
require_once 'php/utilisateur.php';
require_once 'php/photo.php';

$link = getConnection($dbHost, $dbUser, $dbPwd, $dbName);

$imageNom = $_GET["img_nomFich"];

$tabDetail = detail($imageNom, $link);

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
        <th>
          <?php
            echo $tabDetail['nomFich'];
          ?>
        </th>
        <td>
        <?php
          function displayPhotos($array)
          {
            foreach ($array as $value) {
            //$html = '<a href="detail.php"><img class="" src="' . $value . '"></a>';
            //$html = '<a href="detail.php?img_id=id"><img class="" src="' . $value . '"></a>';
            $html = '<a href="detail.php?img_nomFich='. $value . '"><img class="" src="' . $value . '"></a>';
            echo $html;
            }
          }
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
          <?php
            echo $tabDetail['catId']
          ?>
        </td>
      </tr>
    </table>
  </div>

</body>

</html>
