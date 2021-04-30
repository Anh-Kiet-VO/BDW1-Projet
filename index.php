<!--     PAGE D'ACCUEIL     -->

<?php
session_start();
require_once 'php/bd.php';
require_once 'php/utilisateur.php';
require_once 'php/photo.php';

$link = getConnection($dbHost, $dbUser, $dbPwd, $dbName);

$pathsCatList = getImagesPaths($link);

function displayPhotos2($array)
{
    foreach ($array as $value) {
        //$html = '<a href="detail.php"><img class="" src="' . $value . '"></a>';
        //$html = '<a href="detail.php?img_id=id"><img class="" src="' . $value . '"></a>';
        $html = '<img class="" src="' . $value . '">';
        echo $html;
    }
}

if (isset($_POST['submit'])) {
    $selected_val = $_POST['categorie'];

    switch ($selected_val) {
      case 'Tout':
        $pathsCatList = getImagesPaths($link);
        break;
      case 'Chiens':
        $pathsCatList = getImgCategorie($link, 1);
        break;
      case 'Chats':
        $pathsCatList = getImgCategorie($link, 2);
        break;
      case 'Chèvres':
        $pathsCatList = getImgCategorie($link, 3);
        break;
      case 'Singes':
        $pathsCatList = getImgCategorie($link, 4);
        break;
      case 'Quokkas':
        $pathsCatList = getImgCategorie($link, 5);
        break;
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

  <div class="blocprincipal">
    <div class="categories">
      <form action="index.php" method="POST">
        <select name="categorie">
        <option value="Tout">Tout</option>
        <option value="Chiens">Chiens</option>
        <option value="Chats">Chats</option>
        <option value="Chèvres">Chèvres</option>
        <option value="Singes">Singes</option>
        <option value="Quokkas">Quokkas</option>
        </select>
      <input type="submit" name="submit" value="Get Selected Values" />
      </form>
    </div>
    <div class="galerie" data-masonry='{ "itemSelector": "img", "columnWidth": 200 }'><?php displayPhotos($pathsCatList); ?></div>
  </div>

</body>

</html>
