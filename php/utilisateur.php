<?php

/*Cette fonction prend en entrée un pseudo à ajouter à la relation utilisateur et une connexion et
retourne vrai si le pseudo est disponible (pas d'occurence dans les données existantes), faux sinon*/
function checkAvailability($pseudo, $link)
{
    $query = "SELECT u.pseudo FROM utilisateur u WHERE u.pseudo = '". $pseudo ."';";
    $result = executeQuery($link, $query);
    return mysqli_num_rows($result) == 0;
}

/*Cette fonction prend en entrée un pseudo et un mot de passe, associe une couleur aléatoire dans le tableau de taille fixe
array('red', 'green', 'blue', 'black', 'yellow', 'orange') et enregistre le nouvel utilisateur dans la relation utilisateur via la connexion*/
function register($pseudo, $hashPwd, $link)
{
    $colors = array('#7247c1', '#c6397b', '#379ee2', '#7fcd43', '#ffc62e', '#ec412e');
    $index = rand(0, 5);
    $color = $colors[$index];
    $query = "INSERT INTO utilisateur VALUES ('". $pseudo ."', '". $hashPwd ."', '". $color ."', 'disconnected');";
    executeUpdate($link, $query);
}

/*Cette fonction prend en entrée un pseudo d'utilisateur et change son état en 'connected' dans la relation
utilisateur via la connexion*/
function setConnected($pseudo, $link)
{
    $query = "UPDATE utilisateur SET etat = 'connected' WHERE pseudo = '" . $pseudo . "';";
    executeUpdate($link, $query);
}

/*Cette fonction prend en entrée un pseudo et mot de passe et renvoie vrai si l'utilisateur existe (au moins un tuple dans le résultat), faux sinon*/
function getUser($pseudo, $hashPwd, $link)
{
    $query = "SELECT * FROM utilisateur u WHERE u.pseudo = '" . $pseudo . "' AND u.mdp = '" . $hashPwd . "';";
    $result = executeQuery($link, $query);
    return mysqli_num_rows($result) >= 1;
}

/*Cette fonction renvoie un tableau (array) contenant tous les pseudos d'utilisateurs dont l'état est 'connected'*/
function getConnectedUsers($link)
{
    $query = "SELECT u.pseudo FROM utilisateur u WHERE u.etat = 'connected';";
    $usersList = array();
    foreach ($link->query($query) as $row) {
        $usersList[] = $row['pseudo'];
    }
    return $usersList;
}

/*Cette fonction prend en entrée un pseudo d'utilisateur et change son état en 'disconnected' dans la relation
utilisateur via la connexion*/
function setDisconnected($pseudo, $link)
{
    $query = "UPDATE utilisateur SET etat = 'disconnected' WHERE pseudo = '" . $pseudo . "';";
    executeUpdate($link, $query);
}

/*Cette fonction renvoie la couleur associée à un utilisateur pour son affichage dans le fil de discussion*/
function getUserColor($pseudo, $link)
{
    $query = "SELECT couleur FROM utilisateur WHERE pseudo = \"" . $pseudo . "\";";
    $result = executeQuery($link, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['couleur'];
}
