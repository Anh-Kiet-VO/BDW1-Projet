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

function isAdminOrContributor($utilisateur, $imageNom, $link)
{
    $query_admin = "SELECT * FROM Utilisateur WHERE pseudo = '" . $utilisateur . "' AND role = 'admin'";
    $result_admin = executeQuery($link, $query_admin);
    if (mysqli_num_rows($result_admin) == 1) {
        $isAdmin = true;
    } else {
        $isAdmin = false;
    }

    $query_contributor = "SELECT * FROM Utilisateur U JOIN Photo P ON U.pseudo = P.pseudo WHERE U.pseudo = '" . $utilisateur . "' AND P.nomFich = '" . $imageNom . "'";
    $result_contributor = executeQuery($link, $query_contributor);
    if (mysqli_num_rows($result_contributor) == 1) {
        $isContributor = true;
    } else {
        $isContributor = false;
    }

    return ($isAdmin || $isContributor);
}
