<?php
session_start();
require_once 'php/bd.php';
require_once 'php/administrateur.php';
require_once 'php/utilisateur.php';
require_once 'php/photo.php';

$link = getConnection($dbHost, $dbUser, $dbPwd, $dbName);

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
        $html .= $key . ' ' . $value . ' ';
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

  <div class="listeAdmins">Liste des administrateurs : <?php displayAdminsList($adminsList);?></div>

  <div class="statistiques">Nombre total d'utilisateurs : <?php echo $numUsers; ?><br />
  Nombre de photos téléchargées par chaque utilisateur : <?php displayTabStats($numUsersPhotos); ?><br />
Nombre de photos téléchargées dans chaque catégorie : <?php displayTabStats($numCatPhotos); ?></div>

</body>
</html>
