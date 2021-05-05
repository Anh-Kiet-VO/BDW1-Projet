<?php

/*Cette fonction prend en entrée un pseudo à ajouter à la relation utilisateur et une connexion et
retourne vrai si le pseudo est disponible (pas d'occurence dans les données existantes), faux sinon*/
function checkAvailability($pseudo, $link)
{
    $query = "SELECT U.pseudo FROM Utilisateur U WHERE U.pseudo = '". $pseudo ."';";
    $result = executeQuery($link, $query);
    return mysqli_num_rows($result) == 0;
}

/*Cette fonction prend en entrée un pseudo et un mot de passe, associe une couleur aléatoire dans le tableau de taille fixe
array('red', 'green', 'blue', 'black', 'yellow', 'orange') et enregistre le nouvel utilisateur dans la relation utilisateur via la connexion*/
function register($pseudo, $hashPwd, $link)
{
    $query = "INSERT INTO Utilisateur VALUES ('". $pseudo ."', '". $hashPwd ."', 'disconnected', 'user');";
    executeUpdate($link, $query);
}

/*Cette fonction prend en entrée un pseudo d'utilisateur et change son état en 'connected' dans la relation
utilisateur via la connexion*/
function setConnected($pseudo, $tempsConnexion, $link)
{
    $query = "UPDATE Utilisateur SET etat = 'connected' WHERE pseudo = '" . $pseudo . "';";
    executeUpdate($link, $query);
}

/*Cette fonction prend en entrée un pseudo et mot de passe et renvoie vrai si l'utilisateur existe (au moins un tuple dans le résultat), faux sinon*/
function getUser($pseudo, $hashPwd, $link)
{
    $query = "SELECT * FROM Utilisateur U WHERE U.pseudo = '" . $pseudo . "' AND U.mdp = '" . $hashPwd . "';";
    $result = executeQuery($link, $query);
    return mysqli_num_rows($result) >= 1;
}

/*Cette fonction renvoie un tableau (array) contenant tous les pseudos d'utilisateurs dont l'état est 'connected'*/
function getConnectedUsers($link)
{
    $query = "SELECT U.pseudo FROM Utilisateur U WHERE U.etat = 'connected';";
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
    $query = "UPDATE Utilisateur SET etat = 'disconnected' WHERE pseudo = '" . $pseudo . "';";
    executeUpdate($link, $query);
}

function getTempsConnexion($utilisateur, $link)
{
    $query = "SELECT tempsConnexion FROM Utilisateur WHERE pseudo = '" . $utilisateur . "'";
    $temps = executeQuery($link, $query);
    $tabTemps = mysqli_fetch_assoc($temps);
    return $tabTemps['tempsConnexion'];
}

function timeElapsed($secs)
{
    $bit = array(
    'h' => $secs / 3600 % 24,
    'min' => $secs / 60 % 60,
    'sec' => $secs % 60
    );

    foreach ($bit as $k => $v) {
        if ($v > 0) {
            $ret[] = $v . $k;
        }
    }

    if (empty($bit['h']) && empty($bit['min']) && empty($bit['sec'])) {
        return "0sec";
    } else {
        return join(' ', $ret);
    }
}
