<!--     PAGE D'INSCRIPTION     -->

<?php

session_start();
require_once 'php/bd.php';
require_once 'php/utilisateur.php';

$stateMsg = "";

if (isset($_POST["valider"])) {
    $pseudo = $_POST["pseudo"];
    $hashMdp = md5($_POST["mdp"]);
    $hashConfirmMdp = md5($_POST["confirmMdp"]);

    $link = getConnection($dbHost, $dbUser, $dbPwd, $dbName);

    $available = checkAvailability($pseudo, $link);

    if ($hashMdp == $hashConfirmMdp) {
        if ($available) {
            register($pseudo, $hashMdp, $link);
            header('Location: index.php');
        } else {
            $stateMsg = "Le pseudo demand&eacute; est d&eacute;j&agrave; utilis&eacute;";
        }
    } else {
        $stateMsg = "Les mots de passe ne correspondent pas, veuillez r&eacute;essayer";
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

  <div class="loginBanner">
      <div class="errorMsg"><?php echo $stateMsg; ?></div>
      <form action="inscription.php" method="POST">
          <div class="formRegister">
            <div class="loginInfo"><label for="pseudo">Pseudo : </label><input id="pseudo "type="text" name="pseudo"></div>
            <div class="loginInfo"><label for"mdp">Mot de passe : </label><input type="password" name="mdp"></div>
            <div class="loginInfo"><label for"mdp">Mot de passe : </label><input type="password" name="confirmMdp"></div>
            <div><input class="button" type="submit" name="valider" value="S'inscrire"></div>
          </div>
      </form>
      <br />
      <a href="index.php">Déjà inscrit ?</a>
  </div>

</body>

</html>
