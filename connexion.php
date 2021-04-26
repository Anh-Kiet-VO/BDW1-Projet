<!--     PAGE DE CONNEXION     -->

<?php
session_start();
require_once 'php/bd.php';
require_once 'php/utilisateur.php';

$stateMsg = "";

if (isset($_POST["valider"])) {
    $pseudo = $_POST["pseudo"];
    $hashMdp = md5($_POST["mdp"]);

    $link = getConnection($dbHost, $dbUser, $dbPwd, $dbName);

    $exist = getUser($pseudo, $hashMdp, $link);
    if ($exist) {
        setConnected($pseudo, $link);
        $_SESSION["user"] = $pseudo;
        header('Location: index.php');
    } else {
        $stateMsg = "Le couple pseudo/mot de passe ne correspond à aucun utilisateur enregistré";
    }
}

if (isset($_GET["subscribe"])) {
    $successMsg = "<div class='sucessMsg'>L'inscription a bien été effectué, vous pouvez vous connecter</div>";
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

  <div class="connection">
    <div class="errorMsg"><?php echo $stateMsg; ?></div>
    <?php if (isset($successMsg)) {
    echo $successMsg;
} ?>
    <form action="connexion.php" method="POST">
          <div class="formConnection">
              <div class="loginInfo"><label for="pseudo">Pseudo : </label><input id="pseudo "type="text" name="pseudo"></div>
              <div class="loginInfo"><label for"mdp">Mot de passe : </label><input type="password" name="mdp"></div>
              <div><input class="button" type="submit" name="valider" value="Se connecter"></div>
          </div>
    </form>
    <br />
    <a class="loginInfo" href="inscription.php">Première connexion ?</a>
  </div>

</body>

</html>