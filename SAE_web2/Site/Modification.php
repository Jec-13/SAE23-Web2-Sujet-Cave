<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link href="CSS/style.css" rel="stylesheet" type="text/css"/>
    <script type="text/Javascript" src="SCRIPT/script.js"></script>
    <title>Modification Cave</title>
</head>
<?php
include 'INCLUDE/header.php';
session_start();

if (empty($_SESSION['EMAIL'])){
    header('Location: Connexion.php');
    exit();
}
?>
<body>
<header>
<?php
header_page("Modification");
menu_page();
?>
</header>
<article>

</article>
<footer>
    
</footer>
</body>
</html>