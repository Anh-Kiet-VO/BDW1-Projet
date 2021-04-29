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
function detail($imageId, $link)
{
    $query = "SELECT nomFich, description, catId FROM Photo WHERE photoId = " . $imageId;
    $tabDetail = executeQuery($link, $query);
    $assocTabDetail = $tabDetail->fetch_assoc();

    return $assocTabDetail;
}
