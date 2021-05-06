<?php
function getConnectState()
{
    global $utilisateur, $link;
    if (empty($_SESSION)) {
        $connectState = 0;
    } elseif (checkIfAdmin($_SESSION["user"], $link)) {
        //si c'est un admin
        $connectState = 1;
        $utilisateur = $_SESSION["user"];
    } else {
        //si c'est un user
        $connectState = 2;
        $utilisateur = $_SESSION["user"];
    }

    return $connectState;
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

function profilButton($connectState, $utilisateur)
{
    if ($connectState == 2) {
        echo 'Bonjour <a href="./profilUtilisateur.php">' . $utilisateur . '</a> ';
    } else {
        echo 'Bonjour <a href="./profilAdmin.php">' . $utilisateur . '</a> ';
    }
}

function showUser($connectState, $utilisateur, $link)
{
    if (($connectState == 1) || ($connectState == 2)) {
        profilButton($connectState, $utilisateur);

        if (isset($_SESSION["logged"])) {
            $time = time() - $_SESSION["logged"];
            $readableTime = timeElapsed($time);
            echo "<i>(connecté depuis " . $readableTime . ")</i>";
        }
    } else {
        echo "";
    }
}

function connectButton($connectState)
{
    global $connectState;
    if ($connectState == 0) {
        echo '<a class="boutonNav" href="./connexion.php">se connecter</a> <a class="boutonInscrip" href="./inscription.php">s\'inscrire</a>';
    } elseif (($connectState == 1) || ($connectState == 2)) {
        echo '<a class="boutonNav" href="./ajouter.php">ajouter une image</a> <form action="index.php" method="POST"><input class="boutonNav" type="submit" name="deconnexion" value="Se déconnecter"></form>';
    }
}