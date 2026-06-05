<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link href="CSS/style.css" rel="stylesheet" type="text/css"/>
    <script type="text/Javascript" src="SCRIPT/script.js"></script>
    <title>Suppression Cave</title>
</head>
<?php
include 'INCLUDE/header.php';
include 'INCLUDE/functions.php';
include 'INCLUDE/footer.php';
session_start();

if (empty($_SESSION['EMAIL'])){
    header('Location: Connexion.php');
    exit();
}
?>
<body>
<?php
header_page("Mohamed");
menu_page();
?>
<article>

</article>
<?php
footer()
?>
</body>
</html>