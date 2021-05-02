<!--     AJOUT D'UNE PHOTO     -->

<?php
session_start();
require_once 'php/bd.php';
require_once 'php/utilisateur.php';
require_once 'php/photo.php';

$link = getConnection($dbHost, $dbUser, $dbPwd, $dbName);

echo "<br />";

if (empty($_SESSION)) {
  $connectState = 0;
} else {
  $connectState = 1;
  $utilisateur = $_SESSION["user"];
  if (!empty($_SESSION["user"])) {
      $time = time() - $_SESSION["time"];
      $readableTime = timeElapsed($time);
      echo $readableTime;
      echo "<br />";
      echo "Bonjour " . $utilisateur;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Application mini-Pinterest</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
</head>

<form action="ajouter.php" method="post" enctype="multipart/form-data">
    Image : <br>
    <input type="file" name="fileToUpload" id="fileToUpload" required> <br> <br> 

    Description : <br>
    <input type="text" name="description" id="description" required> <br> <br> 

    Catégorie : <br>
	<select name="categorie">
        <option value="Tout">Tout</option>
        <option value="Chiens">Chiens</option>
        <option value="Chats">Chats</option>
        <option value="Chèvres">Chèvres</option>
        <option value="Singes">Singes</option>
        <option value="Quokkas">Quokkas</option>
    </select> <br> <br> 
    <input type="submit" value="Envoyer" name="submit">
</form>

<?php

/* la requete ici haha cécilia :-)
$getImage = $_POST['categorie'];
$getDescription = $_POST['description'];
$getCategorie = $_POST['categorie'];

INSERT INTO Photo VALUES (21, . '"$getImage"' . , . '"$getDescription"' . , .  '"$getCategorie"');*/

$target_dir = "image/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$uploadOk = 1;

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>
