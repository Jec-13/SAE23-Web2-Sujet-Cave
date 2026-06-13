<?php
include 'functions.php';

$path = '../BDD/cave.sqlite'; // chemin de la base de donner cave
// récupération des éléments de POST pour pouvoir changer et afficher la base
$cru = $_POST["CRU"];
$nego = $_POST["NAME"];
$nb = $_POST["Nb_bouteilles"];

modif_element($path, $nb, $cru, $nego); // modification de la base

afficheTableau(get_liste_vins_one($path, $cru, $nego)); // affichage de la bas
?>