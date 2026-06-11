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
include 'INCLUDE/footer.php';
session_start();

if (empty($_SESSION['EMAIL'])){
    header('Location: Connexion.php');
    exit();
}
?>
<body>
    <?php
    header_page("Principale");
    menu_page();
    ?>
    <article>
        <?php
        afficheTableau(get_liste_vins('BDD/cave.sqlite'));
        ?>

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
    footer()
    ?>
</body>
</html>