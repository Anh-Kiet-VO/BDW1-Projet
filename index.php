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

if (isset($_POST['submit'])) {
    $selected_val = $_POST['categorie'];  // Storing Selected Value In Variable
    echo "You have selected :" .$selected_val;  // Displaying Selected Value
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
    <div class="galerie" data-masonry='{ "itemSelector": "img", "columnWidth": 200 }'><?php displayPhotos($pathsList); ?></div>
  </div>

</body>

</html>
