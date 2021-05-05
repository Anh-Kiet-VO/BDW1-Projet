<!--     DETAIL D'UNE PHOTO     -->

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

$imageNom = $_GET["img_nomFich"];

$tabDetail = detail($imageNom, $link);

$tabNomCat = getNomCat($imageNom, $tabDetail['catId'], $link);

function displayPhoto($nomFich)
{
    $html = '<img class="" src="' . $nomFich . '">';
    echo $html;
}

$confirmMsg = "";

if (isset($_POST['modifier'])) {
    $nouvImageDesc = $_POST["description"];
    $nouvCatId = $_POST["categorie"];

    if (($nouvImageDesc != $tabDetail['description']) || ($nouvCatId != $tabDetail['catId'])) {
        editPhoto($imageNom, $nouvImageDesc, $nouvCatId, $link);
        $confirmMsg = "La photo a bien été modifiée";
        header('refresh:2;url=detail.php?img_nomFich=' . $imageNom);
    } else {
        $confirmMsg = "La description et la catégorie n'ont pas été modifiées";
    }
}

if (isset($_POST['supprimer'])) {
    deletePhoto($imageNom, $link);
    header("refresh:3;url=index.php");
    $confirmMsg = "La photo a bien été supprimée";
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

  <div class="confirmMsg"><?php echo $confirmMsg; ?></div>

  <div class="detailphoto">
    <div class="photo">
      <?php
        displayPhoto($tabDetail['nomFich']);
      ?>
    </div>
    <div class="nomImage">
      <b>Nom du fichier</b> :
      <?php
        echo $tabDetail['nomFich'];
      ?>
    </div>
    <div class="description">
      <b>Description</b> :
      <?php
        echo $tabDetail['description'];
      ?>
    </div>
    <div class="categorie">
      <b>Catégorie</b> :
      <a href="index.php?img_nomCat=<?php
        echo $tabDetail['catId'];
      ?>">
      <?php
        echo $tabNomCat['nomCat'];
      ?>
    </a>
    </div>
  </div>

  <div class="optionsBoutons">
    <form action="" method="POST">
      <input class="boutonOpt" type="submit" name="modifier" value="Modifier">
      <input class="boutonOpt" type="submit" name="supprimer" value="Supprimer">
    </form>
  </div>

  <div class="formModif">
    <form action="" method="POST">
      <div class="modifInfo">
        <label for="nouvDescription">Description : </label>
        <input id="nouvDescription" type="text" name="nouvDescription"></div>
      <div class="modifInfo">
        <label for="newCategorie">Catégorie : </label>
  	    <select name="newCategorie">
          <option value="1">Chiens</option>
          <option value="2">Chats</option>
          <option value="3">Chèvres</option>
          <option value="4">Singes</option>
          <option value="5">Quokkas</option>
        </select>
      </div>
      <div><input type="submit" value="Valider" name="modifier"></div>
    </form>
  </div>

</body>

</html>
