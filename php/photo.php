<?php

// Récupère le chemin de l'image
function getImagesPaths($link)
{
    $query = "SELECT P.nomFich FROM Photo P";
    $pathsList = array();
    foreach ($link->query($query) as $row) {
        $pathsList[] = $row['nomFich'];
    }
    return $pathsList;
}

// Récupère la catégorie de l'image
function getImgCategorie($link, $catId)
{
    $query = "SELECT P.nomFich FROM Photo P WHERE catId = " . $catId;
    $pathsCatList = array();
    foreach ($link->query($query) as $row) {
        $pathsCatList[] = $row['nomFich'];
    }
    return $pathsCatList;
}

// Récupère les informations d'une image en fonction de son Id
function detail($ImageId, $link) {
    $reqNomFich = "SELECT nomFich FROM Photo WHERE photoId = " . $ImageId;
    $nomFich = executeQuery($link, $reqNomFich);
    $fetchNom = $nomFich->fetch_assoc();

    $reqDesc = "SELECT description FROM Photo WHERE photoId = " . $ImageId;
    $description = executeQuery($link, $reqDesc);
    $fetchDesc = $description->fetch_assoc();

    $reqCat = "SELECT nomCat FROM Categorie WHERE catId = (SELECT catId FROM Photo WHERE photoId = " . $ImageId . ")";
    $categorie = executeQuery($link, $reqCat);
    $fetchCat = $categorie->fetch_assoc();
}
