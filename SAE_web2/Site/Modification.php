<?php
session_start();
include 'INCLUDE/header.php';
include 'INCLUDE/functions.php';
include 'INCLUDE/footer.php';
include 'INCLUDE/form_modif.php';

if (empty($_SESSION['EMAIL'])){
    header('Location: Connexion.php');
    exit();
} elseif (!$_SESSION['ADMIN']){
    header('Location: index.php');
    exit();
}

// === Requête AJAX : on renvoie SEULEMENT le tableau ===
if (isset($_POST['ajax']) && isset($_GET['type'])) {
    $liste_origine = get_liste_vinsnegoc('BDD/cave.sqlite', 'CRU');
    from_modif($liste_origine[$_GET['type']], 'BDD/cave.sqlite', $_GET['type']);
    exit();   // on s'arrête : pas de HTML complet
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link href="CSS/style.css" rel="stylesheet" type="text/css"/>
    <script type="text/Javascript" src="SCRIPT/script.js"></script>
    <title>Modification Cave</title>
</head>
<body>
<?php
header_page("Principale");
menu_page();
?>
<article>
    <div>
        <form method="GET">
            <details>
                <summary><b>Vins par origine</b></summary>
                <ul>
                    <?php
                    $liste_origine=get_liste_vinsnegoc('BDD/cave.sqlite', 'CRU');
                    $i=0;
                    foreach ($liste_origine as $val){
                        $nb = strval($val['NB_BOUTEILLES']);
                        echo '<li><a href="?type='.strval($i).'">'.$val['CRU']." ".$val['COULEUR']." provient de : ".$val['NOM']." avec {$nb} boutielles en stock</a></li>";
                        $i+=1;
                    }
                    ?>
                </ul>
            </details>
        </form>
    </div>
    <?php
    if (isset($_GET['type'])){
        from_modif($liste_origine[$_GET['type']]);
    }
    ?>
</article>
<?php
footer()
?>
</body>
</html>
