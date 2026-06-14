<?php
include 'INCLUDE/header.php';
include 'INCLUDE/functions.php';
include 'INCLUDE/footer.php';
session_start();

if (empty($_SESSION['EMAIL'])){ // vérification que l'utilisateur est bien connecté sinon redirection vers la page de connexion
    header('Location: Connexion.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link href="CSS/style.css" rel="stylesheet" type="text/css"/>
    <script type="text/Javascript" src="SCRIPT/script.js"></script>
    <title>Index Cave</title>
</head>
<body>
    <?php
    header_page("Principale"); // affichage du header
    menu_page(); // affichage du menu de navigation entre les pages
    ?>
    <article>
        <?php
        afficheTableau(get_liste_vins('BDD/cave.sqlite')); // affichage du tableau avec tous les vins disponibles
        ?>
        <!-- fait par Lucien (ETU1) -->
        <form method="GET">
            <details>
                <summary><b>Vins par origine</b></summary>
                <ul>
                    <?php
                    $liste_origine=get_element_list('BDD/cave.sqlite', 'ORIGINE');
                    foreach ($liste_origine as $val){
                        echo '<li><a href="?type='.$val['ORIGINE'].'">'.$val['ORIGINE'].'</a></li>';
                    }
                    ?>
                </ul>
            </details>

        </form>
        <?php
        if(isset($_GET['type'])){
            afficheTableau(get_vins_by_origin('BDD/cave.sqlite', $_GET['type']));
        }
        ?>
    </article>
    <?php
    footer() // affichage du footer
    ?>
</body>
</html>