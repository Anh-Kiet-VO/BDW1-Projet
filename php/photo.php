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
    $query = "SELECT P.nomFich FROM Photo P WHERE catId = " . $catId . ";";
    $pathsCatList = array();
    foreach ($link->query($query) as $row) {
        $pathsCatList[] = $row['nomFich'];
    }
    return $pathsCatList;
}

// Récupère nom de la catégorie d'après son Id
function getNomCat($imageNom, $catId, $link)
{
    $query = "SELECT C.nomCat FROM Categorie C JOIN Photo P ON C.catId = " . $catId . " WHERE P.nomFich = '" . $imageNom . "';";
    $nomCat = executeQuery($link, $query);
    $assocNomCat = $nomCat->fetch_assoc();

    return $assocNomCat;
}

// Récupère les informations d'une image en fonction de son Id
function detail($imageNom, $link)
{
    $query = "SELECT nomFich, description, catId FROM Photo WHERE nomFich = '" . $imageNom . "';";
    $tabDetail = executeQuery($link, $query);
    $assocTabDetail = $tabDetail->fetch_assoc();

    return $assocTabDetail;
}
