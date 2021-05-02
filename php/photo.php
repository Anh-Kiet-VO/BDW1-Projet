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

function addPhoto($imageNom, $imageDesc, $catId, $link)
{
    /* AJOUTE LA PHOTO SUR LE SERVEUR */
    $target_dir = "./image/";
    $target_file = $target_dir . $imageNom;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $new_target_file = $target_dir . "temp";
    $uploadOk = 1;

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($new_target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 100000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $new_target_file)) {
            echo "The file ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    /* AJOUTE LA PHOTO SUR LA BASE DE DONNEES */
    $query = "INSERT INTO Photo(nomFich, description, catId) VALUES ('" . $new_target_file . "', '" . $imageDesc . "', " . $catId . ")";
    executeUpdate($link, $query);
}

function getTempPhotoId($link)
{
    $query = "SELECT photoId FROM Photo WHERE nomFich = './image/temp'";
    $result = executeQuery($link, $query);
    $tabResult = mysqli_fetch_assoc($result);
    return $tabResult['photoId'];
}

function renamePhoto($fileType, $link)
{
    $photoId = getTempPhotoId($link);

    /* RENOMME SUR LE SERVEUR */
    $new_path = "./image/DSC_" . $photoId . "." . $fileType;
    rename("./image/temp", $new_path);

    /* RENOMME DANS LA BASE DE DONNEES */
    $query = "UPDATE Photo SET nomFich = './image/DSC_" . $photoId . "." . $fileType . "' WHERE photoId = " . $photoId;
    executeUpdate($link, $query);
}
