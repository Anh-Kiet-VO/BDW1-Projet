<?php

$dbHost = "localhost";
$dbUser = "p1908025";
$dbPwd = "Switch57Spinal";
$dbName = "p1908025";

/*Cette fonction prend en entrée l'identifiant de la machine hôte de la base de données, les identifiants (login, mot de passe) d'un utilisateur autorisé sur la base de données contenant les tables pour le chat et renvoie une connexion active sur cette base de donnée. Sinon, un message d'erreur est affiché.*/
function getConnection($dbHost, $dbUser, $dbPwd, $dbName)
{
    //Crée une connexion
    $connexion = mysqli_connect($dbHost, $dbUser, $dbPwd, $dbName);

    //Vérifie la connexion
    if (!$connexion) {
        echo "Erreur lors de la connexion à la base de données : (" . mysqli_connect_errno() . ") " . mysqli_connect_error();
    }

    return $connexion;
}

/*Cette fonction prend en entrée une connexion vers la base de données du chat ainsi
qu'une requête SQL SELECT et renvoie les résultats de la requête. Si le résultat est faux, un message d'erreur est affiché*/
function executeQuery($link, $query)
{
    $resultat = mysqli_query($link, $query, MYSQLI_STORE_RESULT);

    if (!$resultat) {
        echo "Le résultat de la requête " . $query . " est faux";
    }

    return $resultat;
}

/*Cette fonction prend en entrée une connexion vers la base de données du chat ainsi
qu'une requête SQL INSERT/UPDATE/DELETE et ne renvoie rien si la mise à jour a fonctionné, sinon un
message d'erreur est affiché.*/
function executeUpdate($link, $query)
{
    $resultat = mysqli_query($link, $query);

    if (!$resultat) {
        echo "Le résultat de la requête " . $query . " est faux";
    }
}

/*Cette fonction ferme la connexion active $link passée en entrée*/
function closeConnexion($link)
{
    mysqli_close($link);
}
