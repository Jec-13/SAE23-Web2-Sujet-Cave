
<?php
function header_page($nom){
    // fonction qui affiche le header sur tous les sites
    ?>
    <header>
    <div class='header_page'>
    <?php
    $role = $_SESSION['ADMIN'] ? 'ADMIN' : 'USER'; // vérifie si l'utilisateur est admin 
    echo "<h1 class='Cave_Name'>Bienvenue Chez Lucas !</h1>";
    echo "<h1 class='email_title'>Connecté en tant que : ". $_SESSION['EMAIL']."</h1>"; // affichage de ses autorisations
    echo "<h2 class='page_title'>Sur la page : ".$nom."</h2>"; // affichage du nom de la page
    echo "<p class='role_title'>Votre profil est ".$role."</p>";
    ?>
    <p><a class="btn-deconnexion" href='INCLUDE/deco.php'>se déconnecter</a></p> <!--bouton de déconnexion et qui redirige vers deco.php-->
    </div>
    <?php
}

function menu_page(){
    // fonction qui permet d'afficher la nav bar du site
    ?>
    <div class='menu_page'>
    <ul class="liste_Page">
    <li  class='liste_Page' ><a class="btn-menu" href='index.php'>Page principale</a></li>
    <li class='liste_Page' ><a class='btn-menu' href='Mohamed.php'>Page de Mohamed</a></li>
    <?php 
    if ($_SESSION['ADMIN']){ // si l'utilisateur est admin alors il a le droit d'accéder aux pages suivantes :
        echo "<li class='liste_Page' ><a class='btn-menu' href='Insertion.php'>Page d'insertion</a></li>";
        echo "<li class='liste_Page' ><a class='btn-menu' href='Modification.php'>Page de modification</a></li>";
        echo "<li class='liste_Page' ><a class='btn-menu' href='Suppression.php'>Page de suppression</a></li>";
    }
    ?>
    </ul>
    </div>
    </header>
    <?php
}
?>