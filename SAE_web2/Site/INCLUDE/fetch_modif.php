<?php
include 'functions.php';

$path = '../BDD/cave.sqlite'; // chemin de la base de donner cave

// vérification de $_POST
if (!empty($_POST) && isset($_POST["CRU"]) && isset($_POST["NAME"]) && isset($_POST["Nb_bouteilles"])){
    // récupération des éléments de POST pour pouvoir changer et afficher la base
    $cru = $_POST["CRU"];
    $nego = $_POST["NAME"];
    $nb = $_POST["Nb_bouteilles"];
    $scase = $_POST["scase"];
    $coord = $_POST["coord"];

    if ($scase === $coord){ // vérification de la validiter du capcha
        modif_element($path, $nb, $cru, $nego); // modification de la base
        afficheTableau(get_liste_vins_one($path, $cru, $nego)); // affichage de l'élément modifier 
    } else{ // affichage de l'erreur capcha
        echo "<p id='ercap2' class='ercap2'> Le capcha doit être résolue</p>";
    }
}
?>