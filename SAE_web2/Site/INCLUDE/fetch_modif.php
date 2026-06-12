<?php
include 'functions.php';

$path = '../BDD/cave.sqlite';
$cru = $_POST["CRU"];
$nego = $_POST["NAME"];
$nb = $_POST["Nb_bouteilles"];

modif_element($path, $nb, $cru, $nego);

afficheTableau(get_liste_vins_one($path, $cru, $nego));
?>