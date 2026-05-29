<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link href="CSS/style.css" rel="stylesheet" type="text/css"/>
    <script type="text/Javascript" src="SCRIPT/script.js"></script>
    <title>Index Cave</title>
</head>
<?php
include 'INCLUDE/header.php';
include 'INCLUDE/functions.php';
session_start();

if (empty($_SESSION['EMAIL'])){
    header('Location: Connexion.php');
    exit();
}
?>
<body>
<header>
<?php
header_page("Principale");
menu_page();
?>
</header>
<article>
<?php
afficheTableau(get_liste_vins('BDD/cave.sqlite'));
?>
</article>
<footer>
    
</footer>
</body>
</html>