<?php

/*Cette fonction prend en entrée un pseudo à ajouter à la relation administrateur et une connexion et
retourne vrai si le pseudo est disponible (pas d'occurence dans les données existantes), faux sinon*/
function checkAvailabilityAdmin($pseudo, $link)
{
    $query = "SELECT * FROM Administrateur WHERE adminPseudo = '". $pseudo ."';";
    $result = executeQuery($link, $query);
    return mysqli_num_rows($result) == 0;
}

/*Cette fonction prend en entrée un pseudo et un mot de passe, associe une couleur aléatoire dans le tableau de taille fixe
array('red', 'green', 'blue', 'black', 'yellow', 'orange') et enregistre le nouvel administrateur dans la relation administrateur via la connexion*/
function registerAdmin($pseudo, $hashPwd, $link)
{
	$query = "INSERT INTO Administrateur(adminPseudo, adminMdp) VALUES ('". $pseudo ."', '". $hashPwd ."', 'disconnected', 'user');";
	executeUpdate($link, $query);
}

/*Cette fonction prend en entrée un pseudo et mot de passe et renvoie vrai si l'administrateur existe (au moins un tuple dans le résultat), faux sinon*/
function getUserAdmin($pseudo, $hashPwd, $link)
{
	$query = "SELECT * FROM Administrateur WHERE adminPseudo = '" . $pseudo . "' AND adminMdp = '" . $hashPwd . "';";
    $result = executeQuery($link, $query);
    return mysqli_num_rows($result) >= 1;
}

?>