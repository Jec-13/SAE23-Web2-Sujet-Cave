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
include 'INCLUDE/functions.php';
include 'INCLUDE/footer.php';
include 'INCLUDE/form_modif.php';

session_start();
if (empty($_SESSION['EMAIL'])){
    header('Location: Connexion.php');
    exit();
} elseif (!$_SESSION['ADMIN']){
    header('Location: index.php');
    exit();
}
?>
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
                        echo '<li><a href="?type='.strval($i).'">'.$val['CRU']." provient de : ".$val['NOM']." avec {$nb} boutielles en stock</a></li>";
                        $i+=1;
                    }
                    ?>
                </ul>
            </details>

        </form>
    </div>
    <?php
    if (isset($_GET['type'])){
        $tab = from_modif($liste_origine[$_GET['type']], 'BDD/cave.sqlite');
    }
    
    ?>
</article>
<?php
footer()
?>
</body>
</html>