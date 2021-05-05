<!--     AJOUT D'UNE PHOTO     -->

<?php
session_start();
require_once 'php/bd.php';
require_once 'php/administrateur.php';
require_once 'php/utilisateur.php';
require_once 'php/photo.php';

$link = getConnection($dbHost, $dbUser, $dbPwd, $dbName);

$utilisateur = "";

function getConnectState()
{
    global $utilisateur, $link;
    if (empty($_SESSION)) {
        $connectState = 0;
    } elseif (checkIfAdmin($_SESSION["user"], $link)) {
        //si c'est un admin
        $connectState = 1;
        $utilisateur = $_SESSION["user"];
    } else {
        //si c'est un user
        $connectState = 2;
    }

    return $connectState;
}

$connectState = getConnectState();


function profilButton($connectState)
{
    global $utilisateur;
    if ($connectState == 2) {
        echo 'Bonjour <a href="./profilUtilisateur.php">' . $utilisateur . '</a> ';
    } else {
        echo 'Bonjour <a href="./profilAdmin.php">' . $utilisateur . '</a> ';
    }
}

function showUser($connectState, $link)
{
    global $utilisateur;
    if ($connectState == 1) {
        profilButton($connectState);

        if (isset($_SESSION["logged"])) {
            $time = time() - $_SESSION["logged"];
            $readableTime = timeElapsed($time);
            echo "<i>(connecté depuis " . $readableTime . ")</i>";
        }
    } else {
        echo "";
    }
}

function connectButton($connectState)
{
    if ($connectState == 0) {
        echo '<a class="boutonNav" href="./connexion.php">se connecter</a> <a class="boutonInscrip" href="./inscription.php">s\'inscrire</a>';
    } elseif (($connectState == 1) || ($connectState == 2)) {
        echo '<a class="boutonNav" href="./ajouter.php">ajouter une image</a> <form action="index.php" method="POST"><input class="boutonNav" type="submit" name="deconnexion" value="Se déconnecter"></form>';
    }
}

if (isset($_POST['ajouter'])) {
    $getImage = basename($_FILES["fileToUpload"]["name"]);
    $getDescription = $_POST["description"];
    $getCategorie = $_POST["categorie"];
    $getUser = $_SESSION["user"];
    $imageFileType = strtolower(pathinfo($getImage, PATHINFO_EXTENSION));
    $uploadOk = addPhoto($getImage, $getDescription, $getCategorie, $getUser, $link);
    if ($uploadOk == 1) {
        $new_path = renamePhoto($imageFileType, $link);
        header('Location: detail.php?img_nomFich=' . $new_path);
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

  <div class="navigation">
    <div class="nav-utilisateur">
      <?php showUser($connectState, $link); ?>
    </div>
    <div class="nav-boutons">
      <a class="boutonNav" href="./index.php">accueil</a>
      <?php connectButton($connectState); ?>
    </div>
  </div>

  <div class="ajouter">
    <form action="ajouter.php" method="post" enctype="multipart/form-data">
      Image : <br>
      <input type="file" name="fileToUpload" id="fileToUpload" required><br><br>

      Description : <br>
      <input type="text" name="description" id="description" required> <br> <br>

      Catégorie : <br>
  	<select name="categorie">
          <option value="1">Chiens</option>
          <option value="2">Chats</option>
          <option value="3">Chèvres</option>
          <option value="4">Singes</option>
          <option value="5">Quokkas</option>
      </select> <br> <br>
      <input type="submit" value="Envoyer" name="ajouter">
  </form>
  </div>

</body>
</html>
