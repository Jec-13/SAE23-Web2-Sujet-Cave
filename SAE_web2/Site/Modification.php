<?php
session_start();
include 'INCLUDE/header.php';
include 'INCLUDE/functions.php';
include 'INCLUDE/footer.php';
include 'INCLUDE/form_modif.php';

if (empty($_SESSION['EMAIL'])){ // vérification que l'utilisateur est bien connecté sinon redirection vers la page de connexion
    header('Location: Connexion.php');
    exit();
} elseif (!$_SESSION['ADMIN']){ // vérification que l'utilisateur est bien administrateur sinon redirection vers la page d'index
    header('Location: index.php');
    exit();
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
header_page("Principale"); // affichage du header
menu_page(); // affichage du menu de navigation entre les pages
?>
<article>
    <div>
        <form method="GET">
            <details>
                <summary><b>Vins par origine</b></summary>
                <ul>
                    <?php
                    $liste_origine=get_liste_vinsnegoc('BDD/cave.sqlite'); // renvoie le cru, la couleur et le nom du négociant de chaque vin
                    $i=0;
                    foreach ($liste_origine as $val){
                        $nb = strval($val['NB_BOUTEILLES']);// affichage d'un bouton déroulant pour afficher tous les vins à modifier
                        echo '<li><a href="?type='.strval($i).'">'.$val['CRU']." ".$val['COULEUR']." provient de : ".$val['NOM']." avec {$nb} bouteilles en stock</a></li>";
                        $i+=1;
                    }
                    ?>
                </ul>
            </details>
        </form>
    </div>
    <?php
    if (!empty($_GET) && isset($_GET['type'])){ // si le formulaire est bon on appelle form_modif.php pour faire le ch
        from_modif($liste_origine[$_GET['type']]);
    }
    ?>
</article>
<?php
footer()
?>
</body>
</html>
