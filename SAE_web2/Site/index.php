<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link href="css/style.css" rel="stylesheet" type="text/style.css" />
    <script type="text/Javascript" src="SCRIPT/script.js"></script>
    <title>Index Cave</title>
</head>
<?php
session_start();

if (empty($_SESSION['EMAIL'])){
    header('Location: Connexion.php');
    exit();
}
if ($_SESSION['ADMIN']){
    echo '<p>vou êtes admin</p>';
}
else{
    echo "<p>vou n'êtes pas admin</p>";
}
?>
<body>
<header>

</header>
<article>
<p><a href='INCLUDE/deco.php'>se déconecter</a></p>
</article>
<footer>
    
</footer>
</body>
</html>