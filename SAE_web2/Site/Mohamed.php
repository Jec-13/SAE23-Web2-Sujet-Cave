<?php
include 'INCLUDE/header.php';
include 'INCLUDE/functions.php';
include 'INCLUDE/footer.php';
session_start();

// Vérification que l'utilisateur est connecté, sinon redirection vers la page de connexion
if (empty($_SESSION['EMAIL'])){
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
    menu_page();               // affichage du menu de navigation entre les pages
    ?>
    <article>
        <?php
        // Affichage du tableau avec tous les vins disponibles
        afficheTableau(get_liste_vins('BDD/cave.sqlite'));
        ?>

        <!-- fait par Mohamed (ETU2) -->

        <!-- Bloc déroulant : Vins par négociants -->
        <form method="GET">
            <details>
                <summary><b>Vins par négociants</b></summary>
                <ul>
                    <?php
                    // Connexion à la BDD et récupération de tous les négociants (sans doublons)
                    $madb = new PDO('sqlite:BDD/cave.sqlite');
                    $requete = "SELECT DISTINCT NOM FROM negociants ORDER BY NOM";
                    $resultat = $madb->query($requete);
                    $liste_negociants = $resultat->fetchAll(PDO::FETCH_ASSOC);

                    // Affichage de chaque négociant sous forme de lien cliquable
                    foreach ($liste_negociants as $val){
                        echo '<li><a href="?negociant='.$val['NOM'].'">'.$val['NOM'].'</a></li>';
                    }
                    ?>
                </ul>
            </details>
        </form>

        <?php
        // Si un négociant a été sélectionné dans l'URL, affichage des vins correspondants
        if(isset($_GET['negociant'])){
            $madb = new PDO('sqlite:BDD/cave.sqlite');
            $negociant = $_GET['negociant'];
            $requete = "SELECT vins.CRU, vins.COULEUR, vins.ORIGINE, negociants.NOM as 'NOM NEGOCIANT', negociants.REGION as 'REGION NEGOCIANT', cave.NB_BOUTEILLES as 'nombre de bouteilles en stock'
                        FROM cave
                        JOIN negociants ON negociants.noN=cave.noN
                        JOIN vins on vins.noV=cave.noV
                        WHERE negociants.NOM='$negociant'";
            $resultat = $madb->query($requete);
            $tableau = $resultat->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($tableau)){
                afficheTableau($tableau);
            }
        }
        ?>

        <!-- Bloc déroulant : Vins par couleur -->
        <form method="GET">
            <details>
                <summary><b>Vins par couleur</b></summary>
                <ul>
                    <?php
                    // Récupération de toutes les couleurs distinctes depuis la table vins
                    $liste_couleur = get_element_list('BDD/cave.sqlite', 'COULEUR');
                    foreach ($liste_couleur as $val){
                        echo '<li><a href="?couleur='.$val['COULEUR'].'">'.$val['COULEUR'].'</a></li>';
                    }
                    ?>
                </ul>
            </details>
        </form>

        <?php
        // Si une couleur a été sélectionnée dans l'URL, affichage des vins correspondants
        if(isset($_GET['couleur'])){
            $madb = new PDO('sqlite:BDD/cave.sqlite');
            $couleur = $_GET['couleur'];
            $requete = "SELECT vins.CRU, vins.COULEUR, vins.ORIGINE, negociants.NOM as 'NOM NEGOCIANT', negociants.REGION as 'REGION NEGOCIANT', cave.NB_BOUTEILLES as 'nombre de bouteilles en stock'
                        FROM cave
                        JOIN negociants ON negociants.noN=cave.noN
                        JOIN vins on vins.noV=cave.noV
                        WHERE vins.COULEUR='$couleur'";
            $resultat = $madb->query($requete);
            $tableau = $resultat->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($tableau)){
                afficheTableau($tableau);
            }
        }
        ?>

    </article>

    <?php
    footer() // affichage du footer
    ?>
</body>
</html>
