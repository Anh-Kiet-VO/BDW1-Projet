<!--     PROFIL D'UN ADMIN     -->

<?php
session_start();
require_once 'php/bd.php';
require_once 'php/nav_connexion.php';
require_once 'php/administrateur.php';
require_once 'php/utilisateur.php';
require_once 'php/photo.php';

$link = getConnection($dbHost, $dbUser, $dbPwd, $dbName);
$connectState = getConnectState();

$adminsList = getAllAdmins($link);

$numUsers = getNumUsers($link);
$numUsersPhotos = getNumUsersPhotos($link);
$numCatPhotos = getNumCatPhotos($link);

function displayAdminsList($array)
{
    $html = '';
    foreach ($array as $value) {
        $html .= $value . ' ';
    }
    echo $html;
}

function displayTabStats($array)
{
    $html = '';
    foreach ($array as $key => $value) {
        $html .= '<tr><td>' . $key . '</td><td>' . $value . '</td></tr>';
    }
    echo $html;
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

  <div class="navigation">
    <div class="nav-utilisateur">
      <?php showUser($connectState, $utilisateur, $link); ?>
    </div>
    <div class="nav-boutons">
      <a class="boutonNav" href="./index.php">accueil</a>
      <?php connectButton($connectState); ?>
    </div>
  </div>

  <div class="listeAdmins"><div class="grand-titre"><span>Liste des administrateurs :</span></div><br />
  <?php displayAdminsList($adminsList);?></div>

  <div class="statistiques">
    <div class="grand-titre"><span>Les statistiques</span></div><br />
    • <b>Nombre total d'utilisateurs :</b> <?php echo $numUsers; ?><br /><br />
    • <b>Nombre de photos téléchargées par chaque utilisateur :</b><br />
    <table>
      <thead>
        <th>Utilisateur</th><th>Nombre de photos postées</th>
      </thead>
      <tbody>
      <?php displayTabStats($numUsersPhotos); ?>
      </tbody>
    </table>
    • <b>Nombre de photos téléchargées dans chaque catégorie :</b><br />
    <table>
      <thead>
        <th>Catégorie</th><th>Nombre de photos postées</th>
      </thead>
      <tbody>
      <?php displayTabStats($numCatPhotos); ?>
      </tbody>
    </table>
  </div>

</body>
</html>
